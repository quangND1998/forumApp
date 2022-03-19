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

class ReplieController extends Controller
{

    public function getDetail($name)
    {
        $chanels = Chanels::get();
        $conversation = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies.users', 'chanel')->where('slug', $name)->first();
        // return $conversation;
        // return $conversation;
        // $conversation = new ConversationResource($conversation);
        // return $conversation;

        if ($conversation !== null) {

            $conversation->view = $conversation->view + 1;
            $conversation->save();

            // return $conversation->initalReplies;
            $initalReplies = InitalReplieResource::collection($conversation->initalReplies);

            $conversation = new ConversationResource($conversation);
            return Inertia::render('Forum/Replie', compact('conversation', 'chanels', 'initalReplies'));
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
        return back()->with('success', " Reply succesffly");
    }

    public function likeRelie($id, Request $reuest)
    {
        $replie = Replies::findOrFail($id);
        if ($replie->users->contains(Auth::user()->id)) {

            $replie->users()->detach(Auth::user());
        } else {

            $replie->users()->attach(Auth::user());
        }
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
        $this->validate(
            $request,
            [

                'body' => 'required',

            ]
        );

        $replie->body = $request->body;
        $replie->save();

        return back()->with('success', "Update Reply succesffly");
    }

    public function bestAnswer(Request $request)
    {
      
        $replie = Replies::find($request->id)->update(['best_answer' => $request->best_answer]);
        return back()->with('success', "Successfully");
    }
}
