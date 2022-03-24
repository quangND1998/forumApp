<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chanels;
use Inertia\Inertia;
use App\Models\Conversation;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\ReplieResource;
use App\Models\User;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $category = null;
        $chanels = Chanels::get();
        $category = $request->input('category');
        $chanel = Chanels::with('conversations')->where('title', $category)->first();
        $solved = $request->input('answered');

        if ($chanel !== null && $solved !== null) {

            $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie')->where('solved', $solved)->where('chanel_id', $chanel->id)->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term, 'answered' => $request->input('answered')]);
        } elseif ($chanel == null && $solved !== null) {

            $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie')->where('solved', $solved)->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term, 'answered' => $request->input('answered')]);
        } elseif ($chanel !== null && $solved == null) {

            $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie')->where('chanel_id', $chanel->id)->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term, 'answered' => $request->input('answered')]);
        } else {

            $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie')->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term, 'answered' => $request->input('answered')]);
        }



        $conversations = ConversationResource::collection($conversations);

        return Inertia::render('Forum/Index', compact('chanels', 'conversations', 'category', 'solved'));
    }



    public function getSolved(Request $request)
    {
        $category = null;
        $chanels = Chanels::get();
        $category = $request->input('category');

        if ($category == 'all' || $category == null) {
            $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie')->where('solved', 1)->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term]);
        } else {
            $chanel = Chanels::findOrFaiL($category);
            $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie')->where('solved', 1)->where('chanel_id', $chanel->id)->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term]);
        }



        $conversations = ConversationResource::collection($conversations);

        return Inertia::render('Forum/Solved', compact('chanels', 'conversations', 'category'));
    }

    public function getUnsolved(Request $request)
    {
        $category = null;
        $chanels = Chanels::get();
        $category = $request->input('category');
        $answered = $request->input('answered');
        if ($category == 'all' || $category == null) {
            $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie')->where('solved', 0)->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term]);
        } else {
            $chanel = Chanels::findOrFaiL($category);
            $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie')->where('solved', 0)->where('chanel_id', $chanel->id)->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->term . '%');
            })->paginate(20)->appends(['term' => $request->term]);
        }



        $conversations = ConversationResource::collection($conversations);

        return Inertia::render('Forum/Solved', compact('chanels', 'conversations', 'category'));
    }

    public function profile($name)
    {

        $user = User::with('replies.conversation', 'conversations')->where('name', $name)->first();
        // $activities= User::with()

        if ($user) {
            $user = new ProfileResource($user);
            return Inertia::render('Profile/Index', compact('user'));
        } else {
            $erros = "Not found user !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }

    public function editProfile($name)
    {
        $user = User::with('replies.conversation', 'conversations')->where('name', $name)->first();
        // $activities= User::with()

        if ($user) {
            $user = new ProfileResource($user);
            return Inertia::render('Profile/Edit', compact('user'));
        } else {
            $erros = "Not found user !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }
}
