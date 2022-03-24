<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\ReplieResource;
use Inertia\Inertia;
use App\Models\Chanels;
use App\Models\Replies;

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
        Conversation::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'chanel_id' => $request->chanel_id,
            'user_id' => Auth::user()->id
        ]);
        return back()->with('success', 'Create question successfully');
    }

    public function update(Request $request, $id)
    {
        $conversation = Conversation::findOrFail($id);
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
        return back()->with('success', 'Update question successfully');
    }

    public  function delete($id)
    {
        $conversation = Conversation::findOrFail($id);
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
    
        $conversation = Conversation::find($request->id)->update(['solved' => $request->solved]);;
        return back()->with('success', "Successfully");
    }
}
