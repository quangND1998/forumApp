<?php

namespace App\Http\Controllers;


use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\ReplieResource;
use App\Models\Activities;
use Inertia\Inertia;
use App\Models\Chanels;
use App\Models\Replies;
use App\Jobs\ListenUserAcivity;
use App\Jobs\UpdateActivity;
use Illuminate\Support\Carbon;
use App\Events\NewConversationEvent;
use App\Events\DeleteConvsesationEvent;
use App\Jobs\DeleteConversation;
use App\Events\SovledConversationEvent;
use App\Events\UpdateConversation;
use App\Jobs\UpdateSubject;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Models\Image;
use App\Models\Video;
use Illuminate\Http\Response;
use App\Events\ActiveConversationEvent;
use App\Models\User;
use App\Notifications\NewConversation;
use Illuminate\Support\Facades\Notification;

class ConversationController extends Controller
{
    use FileUploadTrait;
    public function __construct()
    {
        $this->middleware('role_user:default', ['only' => ['store','update','edit','create','delete']]);
        $this->middleware('admin_role', ['only' => ['allQuestion']]);
    }

    public function allQuestion(Request $request){
        $category = null;
        $chanels = Chanels::get();
        $category = $request->input('category');
        $chanel = Chanels::with('conversations')->where('slug', $category)->first();

        if ($chanel !== null) {

            $conversations = Conversation::with('user',  'chanel', 'lastReplie.user', 'images', 'videos')->withCount('all_replies')->where('chanel_id', $chanel->id)->orderBy('created_at', 'desc')->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term]);
        } elseif ($chanel == null ) {

            $conversations = Conversation::with('user',  'chanel', 'lastReplie.user', 'images', 'videos')->withCount('all_replies')->orderBy('created_at', 'desc')->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term]);
        }
  
        $conversations = ConversationResource::collection($conversations);

        return Inertia::render('Forum/Admin/Conversations', compact('chanels', 'conversations', 'category'));
    }

    public function setActive(Request $request){
        $conversation = Conversation::find($request->id);
        $conversation->update(['active' => $request->active]);
        broadcast(new ActiveConversationEvent($conversation))->toOthers();
        return back()->with('success', "Successfully");
    }

    public function create(){
        $chanels = Chanels::get();
        return Inertia::render('Question/NewQuestionComponent',compact('chanels'));
    }

    public function edit($id){
        $conversation = Conversation::with('images','videos')->findOrFail($id);
        $chanels = Chanels::get();
        return Inertia::render('Question/UpdateQuestionComponent',compact('chanels', 'conversation'));
    }
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'title' => 'required|max:255|unique:conversation,title',
                'body' => 'nullable',
                'chanel_id' => 'required',
                'image' => 'nullable|mimes:png,jpg,jpeg,svg',
                'video' =>  'nullable|mimetypes:video/mp4|max:10000'
            ]
        );
        $user = Auth::user();
        $users = User::where('id', '!=', auth()->id())->get();
        $conversation= Conversation::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'chanel_id' => $request->chanel_id,
            // 'user_id' => Auth::user()->id
        ]);
        // $heading= "Started a new Conversation";
        // $icon= "/images/profiles/started_conversation_icon.svg";
        // $pointsEarned= 50;
        // $type="Forum\Conversation";
        $image_path = 'images/';
        $video_path = 'videos/';
        if($request->hasFile('image')){
            $file = $request->file('image');
            $image = new Image();
            $image->name =  $file->getClientOriginalName();
            $image->image = $request->hasFile('image') ? $this->image($request->file('image'), $image_path) : null;
            $conversation->images()->save($image);
        }
        if($request->hasFile('video')){
            $file = $request->file('video');
            $video = new Video();
            $video->name =  $file->getClientOriginalName();
            $video->video = $request->hasFile('video') ? $this->image($request->file('video'), $video_path) : null;
            $conversation->videos()->save($video);
        }
        $activty= Activities::create([
            'heading' => "Started a new Conversation",
            'icon' => "/images/profiles/started_conversation_icon.svg",
            "pointsEarned" => 50, 
            'type' => 0,
        ]);
        $activty->date = Carbon::createFromFormat('Y-m-d H:i:s', $activty->created_at)->format('Y-m-d');
        $activty->save();
        $conversation->activities()->save($activty);
       
        dispatch(new ListenUserAcivity($conversation, $activty));
        $conversation->load('user','chanel','all_replies', 'lastReplie.user');
        Notification::send($users, new NewConversation($conversation));
        broadcast(new NewConversationEvent($conversation))->toOthers();
        return redirect('/myThread')->with('success', 'Create question successfully');
    }

    public function update(Request $request, $id)
    {
        $conversation = Conversation::with('activities.subject','images','videos','all_replies.activities.subject')->findOrFail($id);
      
        $this->validate(
            $request,
            [
                'title' => 'required|max:255|unique:conversation,title,' . $conversation->id,
                'body' => 'nullable',
                'chanel_id' => 'required',
                'image' => 'nullable|mimes:png,jpg,jpeg,svg',
                'video' =>  'nullable|mimetypes:video/mp4|max:10000'
            ]
        );
      
        $conversation->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'chanel_id' => $request->chanel_id,
        ]);
        $image_path = 'images/';
        $video_path = 'videos/';
        $name = time();
        if($request->hasFile('image')){
            $file = $request->file('image');
            if(count($conversation->images) >0){
                $conversation->images[0]->update([
                    'name'=>  $file->getClientOriginalName().'-'.$name,
                    'image' => $request->hasFile('image') ? $this->update_image($request->file('image'),$name ,$image_path, $conversation->images[0]->image) :  $conversation->image[0]->image

                ]);
            }
            else{
                $image = new Image();
                $image->name =  $file->getClientOriginalName();
                $image->image = $request->hasFile('image') ? $this->image($request->file('image'), $image_path) : null;
                $conversation->images()->save($image);
            }

        }
        if($request->hasFile('video')){
            $file = $request->file('video');
            if(count($conversation->videos) >0){
                $conversation->videos[0]->update([
                    'name'=>  $file->getClientOriginalName().'-'.$name,
                    'video' => $request->hasFile('video') ? $this->update_image($request->file('video'),$name ,$video_path, $conversation->videos[0]->video) :  $conversation->image[0]->image

                ]);
            }
            else{
                $video = new Video();
                $video->name =  $file->getClientOriginalName();
                $video->video = $request->hasFile('video') ? $this->image($request->file('video'), $video_path) : null;
                $conversation->videos()->save($video);
            }
        }
        foreach ($conversation->activities as $activty) {
            $activty->subject->title = $request->title;
            $activty->subject->body = $request->body;
            $activty->subject->save();
        }
        foreach ($conversation->all_replies as $replie) {
       
            foreach ($replie->activities as $activty) {
              
                dispatch(new UpdateSubject($activty->subject, $conversation, $replie));
                // $activty->subject->title = $request->title;
                // $activty->subject->body = $request->body;
                // $activty->subject->body='/question/'.Str::slug($this->conversation->slug);
                // $activty->subject->save();
            }
        }
        broadcast(new UpdateConversation($conversation))->toOthers();

        return redirect('/myThread')->with('success', 'Update question successfully');
    }

    public  function delete($id)
    {
        $conversation = Conversation::with('all_replies.activities','activities','all_replies.images','all_replies.videos')->findOrFail($id);
      
        $extension=" ";
        $conversation->activities()->delete();
      
        foreach ($conversation->all_replies as $replie) {
             $replie->activities()->delete();
        }
        foreach ($conversation->images as $image) {
            $this->DeleteFolder($image->image,$extension);
            $image->delete();
        }
        foreach ($conversation->videos as $video) {
            $this->DeleteFolder($video->video,$extension);
            $video->delete();
        }
        foreach ($conversation->all_replies as $replie) {
            foreach ($replie->images as $image) {
             
                $this->DeleteFolder($image->image,$extension);
                $image->delete();
            }
            foreach ($replie->videos as $video) {
             
                $this->DeleteFolder($video->video,$extension);
                $video->delete();
            }
        }
        $conversation->all_replies()->delete();

        //broadcast(new DeleteConvsesationEvent($conversation))->toOthers();
        
        // dispatch(new DeleteConversation($conversation));
        $conversation->delete();
      
        return back()->with('success', 'Update question successfully');
    }

    public function myConversation(Request $request)
    {
        $chanels = Chanels::get();
        $conversations = Conversation::with('user',  'chanel', 'lastReplie.user','images','videos')->withCount('all_replies')->where('user_id', Auth::user()->id)->where(function ($query) use ($request) {
            $query->where('title', 'LIKE', '%' . $request->term . '%');
        })->paginate(20)->appends(['term' => $request->term]);
        // return $conversations;
        $conversations = ConversationResource::collection($conversations);

        return Inertia::render('Forum/MyConversation', compact('conversations', 'chanels'));
    }

    public function makeSolved(Request $request)
    {
    
        $conversation = Conversation::find($request->id);
        $conversation->update(['solved' => $request->solved]);
        broadcast(new SovledConversationEvent($conversation))->toOthers();
        return back()->with('success', "Successfully");
    }

    public function lockComment(Request $request)
    {
    
        $conversation = Conversation::find($request->id);
        $conversation->update(['lock_comment' => $request->lock_comment]);
        broadcast(new SovledConversationEvent($conversation))->toOthers();;
        return back()->with('success', "Successfully");
    }

    public function deleteImage($id){
        $image= Image::findOrFail($id);
        $extension=" ";
        $this->DeleteFolder($image->image,$extension);
        $image->delete();
        return response()->json('Delete successfully', Response::HTTP_OK);
    }
    public function deleteVideo($id){
        $video= Video::findOrFail($id);
        $extension=" ";
        $this->DeleteFolder($video->video,$extension);
        $video->delete();
        return response()->json('Delete successfully', Response::HTTP_OK);
    }
}
