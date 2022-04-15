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

class ConversationController extends Controller
{
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'title' => 'required|max:255|unique:conversation,title',
                'body' => 'nullable',
                'chanel_id' => 'required'
            ]
        );
        $conversation= Conversation::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'chanel_id' => $request->chanel_id,
            'user_id' => Auth::user()->id
        ]);
        // $heading= "Started a new Conversation";
        // $icon= "/images/profiles/started_conversation_icon.svg";
        // $pointsEarned= 50;
        // $type="Forum\Conversation";

        $activty= Activities::create([
            'heading' => "Started a new Conversation",
            'icon' => "/images/profiles/started_conversation_icon.svg",
            "pointsEarned" => 50, 
            'type' => 0,
            'user_id' =>Auth::user()->id
        ]);
        $activty->date = Carbon::createFromFormat('Y-m-d H:i:s', $activty->created_at)->format('Y-m-d');
        $activty->save();
        $conversation->activities()->save($activty);
        dispatch(new ListenUserAcivity($conversation, $activty));
        $conversation->load('user','chanel','all_replies', 'lastReplie.user');
        broadcast(new NewConversationEvent($conversation))->toOthers();;
        

        

        return back()->with('success', 'Create question successfully');
    }

    public function update(Request $request, $id)
    {
        $conversation = Conversation::with('activities.subject','all_replies.activities.subject')->findOrFail($id);
        $this->validate(
            $request,
            [
                'title' => 'required|max:255|unique:chanels,title,' . $conversation->id,
                'body' => 'nullable',
                'chanel_id' => 'required'
            ]
        );
        $conversation->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'chanel_id' => $request->chanel_id,
        ]);
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
        broadcast(new UpdateConversation($conversation));

        return back()->with('success', 'Update question successfully');
    }

    public  function delete($id)
    {
        $conversation = Conversation::with('all_replies.activities','activities')->findOrFail($id);
      
     
        foreach ($conversation->activities as $activty) {
            $activty->delete();
        }
        foreach ($conversation->all_replies as $replie) {
            foreach ($replie->activities as $activty) {
                $activty->delete();
            }
        }
        broadcast(new DeleteConvsesationEvent($conversation));
        
        // dispatch(new DeleteConversation($conversation));
        $conversation->delete();
      
        return back()->with('success', 'Update question successfully');
    }

    public function myConversation(Request $request)
    {
        $chanels = Chanels::get();
        $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user.replies', 'chanel', 'lastReplie')->where('user_id', Auth::user()->id)->where(function ($query) use ($request) {
            $query->where('title', 'LIKE', '%' . $request->term . '%');
        })->paginate(20)->appends(['term' => $request->term]);
        $conversations = ConversationResource::collection($conversations);

        return Inertia::render('Forum/MyConversation', compact('conversations', 'chanels'));
    }

    public function makeSolved(Request $request)
    {
    
        $conversation = Conversation::find($request->id);
        $conversation->update(['solved' => $request->solved]);
        broadcast(new SovledConversationEvent($conversation));
        return back()->with('success', "Successfully");
    }

    public function lockComment(Request $request)
    {
    
        $conversation = Conversation::find($request->id);
        $conversation->update(['lock_comment' => $request->lock_comment]);
        broadcast(new SovledConversationEvent($conversation));
        return back()->with('success', "Successfully");
    }
}
