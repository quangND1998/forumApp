<?php

namespace App\Http\Controllers;

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

class ReplieController extends Controller
{

    public function getDetail(Request $request, $name)
    {
       
      
        $replie_id = $request->input('replyId');
        $conversation = Conversation::with(['user', 'chanel','lastReplie.user'])->withCount('all_replies')->where('slug', $name)->first();

        if($conversation){
            $initalReplies = Replies::with('user','users','replies.users','replies.user','replies.user_reply')->where('is_inital', 1)->where('conversation_id',$conversation->id)->paginate(20);
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
            $initalReplies = InitalReplieResource::collection($initalReplies);

            $conversation = new ConversationResource($conversation);
            // broadcast(new ViewConversationEvent($conversation))->toOthers();
            return Inertia::render('Forum/Replie', compact('conversation', 'initalReplies', 'replie_id'));
        } else {
            $erros = "Not found conversation !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }
    public function store(Request $request, $id)
    {


        $conversation = Conversation::findOrFail($id);
        $this->validate(
            $request,
            [
                'body' => 'required',
            ]
        );

        $replie = Replies::create([
            'body' => $request->body,
            'user_id' => Auth::user()->id,
            'conversation_id' => $conversation->id
        ]);
        if ($request->replie_id == null) {
            $replie->is_inital = 1;
            $replie->save();
        } else {
            $replie->replie_id = $request->replie_id;
            $replie->body = $request->body;
            $replie->replie_user = $request->replie_user;
            $replie->save();
        }
        $replie->load('users', 'user', 'user_reply');

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
        $replie = Replies::findOrFail($id);
        $conversation = Conversation::findOrFail($replie->conversation_id);
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

        $replie = Replies::findOrFail($id);
        $conversation = Conversation::findOrFail($replie->conversation_id);


        $this->validate(
            $request,
            [

                'body' => 'required',

            ]
        );

        $replie->body = $request->body;
        $replie->save();
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
        $best_replie = Replies::with('conversation.all_replies')->with('users', 'user')->find($request->id);
        foreach($best_replie->conversation->all_replies as $replie){
            $replie->update(['best_answer' =>  0]);
        }
        $best_replie->update(['best_answer' => $request->best_answer]);
        $best_replie->load('users', 'user', 'user_reply');
        broadcast(new LikeCommentEvent($best_replie))->toOthers();
        return back()->with('success', "Successfully");
    }
}
