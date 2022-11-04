<?php

namespace App\Http\Controllers;

use App\Events\BestAnswerEvent;
use App\Events\DeleteReplieEvent;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\InitalReplieResource;
use App\Models\Chanels;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\ReplieResource;
use App\Models\Replies;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ReplieActivity;
use App\Jobs\UpdateActivity;
use App\Jobs\LikeCommentActivity;
use App\Models\Activities;
use Illuminate\Support\Carbon;
use App\Events\ReplieCommentEvent;
use App\Events\LikeCommentEvent;
use App\Events\UpdateReplieEvent;
use App\Events\ViewConversationEvent;
use App\Models\Image;
use App\Models\Video;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Notifications\BestAnswer;
use App\Notifications\LikeReplie;
use App\Notifications\NewReplieConversation;
use App\Notifications\NewReplieForReply;
use Illuminate\Support\Facades\Notification;

class ReplieController extends Controller
{
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('role_user:default', ['only' => ['store','likeRelie','update','delete']]);
        $this->middleware('admin_role', ['only' => ['deleteReplie']]);
    }
    public function getDetail(Request $request, $name)
    {
     
        $replie_id = $request->input('replyId');
        $conversation = Conversation::with(['user', 'chanel','lastReplie.user','images','videos'])->withCount('all_replies')->where('active',1)->where('slug', $name)->first();
        if($conversation){
            $initalReplies = Replies::with('user','users','replies.users','replies.user','replies.user_reply','replies.images', 'replies.videos','images','videos')->where('is_inital', 1)->where('conversation_id',$conversation->id)->paginate(20);
        }
        else{
            $erros = "Not found conversation !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }


        // return $conversation;
        // return $conversation;
        // $conversation = new ConversationResource($conversation);
        // return $conversation;

        if ($conversation !== null) {

            $conversation->view = $conversation->view + 1;
            $conversation->save();

            // return $conversation->initalReplies;
            // dd($initalReplies);
            $initalReplies = InitalReplieResource::collection($initalReplies);

            $conversation = new ConversationResource($conversation);
            // dd($conversation);
            // broadcast(new ViewConversationEvent($conversation))->toOthers();
            //  dd($initalReplies);
            return Inertia::render('Forum/Replie', compact('conversation', 'initalReplies', 'replie_id'));
        } else {
            $erros = "Not found conversation !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }
    public function store(Request $request, $id)
    {
        $conversation = Conversation::with('all_replies.user', 'user')->where('active',1)->findOrFail($id);
     
     
        $this->validate(
            $request,
            [
                'body' => 'required',
                'image' => 'nullable|mimes:png,jpg,jpeg,svg',
                'video' =>  'nullable|mimetypes:video/mp4|max:10000'
            ]
        );
        
    
        /* Tạo một comment */
        $replie = Replies::create([
            'body' => $request->body,
            'user_id' => Auth::user()->id,
            'conversation_id' => $conversation->id
        ]);


        $image_path = 'images/';
        $video_path = 'videos/';
        if($request->hasFile('image')){
            $file = $request->file('image');
            $image = new Image();
            $image->name =  $file->getClientOriginalName();
            $image->image = $request->hasFile('image') ? $this->image($request->file('image'), $image_path) : null;
            $replie->images()->save($image);
        }
        if($request->hasFile('video')){
            $file = $request->file('video');
            $video = new Video();
            $video->name =  $file->getClientOriginalName();
            $video->video = $request->hasFile('video') ? $this->image($request->file('video'), $video_path) : null;
            $replie->videos()->save($video);
        }
        if ($request->replie_id == null) {
            $replie->is_inital = 1;
            $replie->save();
        } else {
            $replie->replie_id = $request->replie_id;
            $replie->body = $request->body;
            $replie->replie_user = $request->replie_user;
            $replie->save();
        }
        $replie->load('users', 'user', 'user_reply','images','videos');
        $conversation->load('all_replies.user');

        /* Nếu comment là reReply thì gửi thông báo reply */
        if($replie->replie_user){

            $user= User::find($replie->replie_user);
            Notification::send($user, new NewReplieForReply($replie, $conversation));
        }  /* Ngược lại comment là comment thuần của bài viết  thì gửi thông báo reply on Conversation*/
        else{
            $user = $conversation->user;
            $users=$conversation->all_replies->where('user_id',  '!=' , Auth::user()->id)->pluck('user')->unique();
            $users[] =$user;
            $data= $users->unique();
            Notification::send($data, new NewReplieConversation($replie,$conversation));
        }
        
        broadcast(new ReplieCommentEvent($replie, $conversation))->toOthers();;
        $activty = Activities::create([
            'heading' => "Replied to",
            'icon' => "/images/profiles/replied_to_conversation_icon.svg",
            "pointsEarned" => 10,
            'type' => 1,

        ]);
        $activty->date = Carbon::createFromFormat('Y-m-d H:i:s', $activty->created_at)->format('Y-m-d');
        $activty->save();
        $replie->activities()->save($activty);

        dispatch(new ReplieActivity($conversation, $replie, $activty));

        return back()->with('success', " Reply succesffly");
    }

    public function likeRelie($id, Request $reuest)
    {
        $replie = Replies::with('user')->findOrFail($id);
        $conversation = Conversation::where('active',1)->findOrFail($replie->conversation_id);
        // Notification::route('mail', [
        //     'quangND620@wru.vn' => 'QuangND98',
        // ])->notify( new LikeReplie($replie,$conversation));
        if ($replie->users->contains(Auth::user()->id)) {

            $replie->users()->detach(Auth::user());
            $replie->activities->where('type', 2)->first()->delete();
        } else {
            $activty = Activities::create([
                'heading' => "Liked Comment",
                'icon' => "/images/profiles/liked_comment_icon.svg",
                "pointsEarned" => 50,
                'type' => 2,

            ]);
            $activty->date = Carbon::createFromFormat('Y-m-d H:i:s', $activty->created_at)->format('Y-m-d');
            $activty->save();
            $replie->activities()->save($activty);

            dispatch(new LikeCommentActivity($conversation, $replie, $activty));
            $replie->users()->attach(Auth::user());
            if($replie->user_id !== Auth::user()->id){
                Notification::send($replie->user, new LikeReplie($replie,$conversation));
            }
            
            // $user= User::find($replie->replie_user);
            // Notification::send($user, new NewReplieForReply($replie, $conversation));
        }
        $replie->load('users', 'user', 'user_reply');
        // return $replie;
        broadcast(new LikeCommentEvent($replie))->toOthers();
        return back();

        // if ($replie->users->pivot == null) {
        //     $replie->users()->attach(Auth::user());
        // } elseif ($replie->users->pivot->user_id == Auth::user()->id) {
        //     $replie->users()->detach(Auth::user());
        // } else {
        //     $replie->users()->attach(Auth::user());
        // }
    }

    public function update(Request $request, $id)
    {
        $replie = Replies::with('images', 'videos')->findOrFail($id);
        $conversation = Conversation::findOrFail($replie->conversation_id);
        $this->validate(
            $request,
            [

                'body' => 'required',
                'image' => 'nullable|mimes:png,jpg,jpeg,svg',
                'video' =>  'nullable|mimetypes:video/mp4|max:10000'
            ]
        );

        $replie->body = $request->body;
        $replie->save();
        $image_path = 'images/';
        $video_path = 'videos/';
        $name = time();
        if($request->hasFile('image')){
            $file = $request->file('image');
            if(count($conversation->images) >0){
                $replie->images[0]->update([
                    'name'=>  $file->getClientOriginalName().'-'.$name,
                    'image' => $request->hasFile('image') ? $this->update_image($request->file('image'),$name ,$image_path, $replie->images[0]->image) :  $conversation->image[0]->image

                ]);
            }
            else{
                $image = new Image();
                $image->name =  $file->getClientOriginalName();
                $image->image = $request->hasFile('image') ? $this->image($request->file('image'), $image_path) : null;
                $replie->images()->save($image);
            }

        }
        if($request->hasFile('video')){
            $file = $request->file('video');
            if(count($conversation->videos) >0){
                $conversation->videos[0]->update([
                    'name'=>  $file->getClientOriginalName().'-'.$name,
                    'video' => $request->hasFile('video') ? $this->update_image($request->file('video'),$name ,$video_path, $replie->videos[0]->video) :  $conversation->image[0]->image

                ]);
            }
            else{
                $video = new Video();
                $video->name =  $file->getClientOriginalName();
                $video->video = $request->hasFile('video') ? $this->image($request->file('video'), $video_path) : null;
                $replie->videos()->save($video);
            }
        }
        $replie->load('users', 'user', 'user_reply', 'replies');
        $activty = $replie->activities->where('type', 1)->first();
        $activty->subject->update([
            'body' => $replie->body
        ]);
        broadcast(new UpdateReplieEvent($replie, $conversation))->toOthers();;
        return back()->with('success', "Update Reply succesffly");
    }

    public function bestAnswer(Request $request)
    {
        $best_replie = Replies::with('conversation.all_replies','users', 'user')->find($request->id);
        foreach($best_replie->conversation->all_replies as $replie){
            $replie->update(['best_answer' =>  0]);
        }
        $best_replie->update(['best_answer' => $request->best_answer]);
  
        $best_replie->load('users', 'user', 'user_reply','conversation');
        if($best_replie->best_answer ==1){
            Notification::send($best_replie->user, new BestAnswer($best_replie,$best_replie->conversation));
        }
       
        broadcast(new BestAnswerEvent($best_replie))->toOthers();
        return back()->with('success', "Successfully");
    }

    public function deleteReplie($id){
        $reply=Replies::with('replies.images', 'replies.videos', 'replies.activities','activities')->findOrFail($id);
        $extension=" ";
        //broadcast(new DeleteReplieEvent($reply))->toOthers();
        if($reply->is_inital ==1){
            foreach($reply->replies as $re){
                foreach ($re->images as $image) {
             
                    $this->DeleteFolder($image->image,$extension);
                    $image->delete();
                }
                foreach ($re->videos as $video) {
                 
                    $this->DeleteFolder($video->video,$extension);
                    $video->delete();
                }
                $re->activities()->delete();
                $re->delete();
            }
            $reply->activities()->delete();
          
        }
        else{
            foreach ($reply->images as $image) {
             
                $this->DeleteFolder($image->image,$extension);
                $image->delete();
            }
            foreach ($reply->videos as $video) {
             
                $this->DeleteFolder($video->video,$extension);
                $video->delete();
            }
            $reply->activities()->delete();
        }

       
        $reply->delete(); 
        return back()->with('success', 'Delete successfully');

    }
}
