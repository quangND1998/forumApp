<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chanels;
use Inertia\Inertia;
use App\Models\Conversation;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\ReplieResource;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $chanels = Chanels::get();
        $conversations = Conversation::with('user', 'all_replies', 'initalReplies.user', 'initalReplies.replies', 'chanel', 'lastReplie')->where(function ($query) use ($request) {
            $query->where('title', 'LIKE', '%' . $request->term . '%');
        })->paginate(20)->appends(['term' => $request->term]);

        $conversations = ConversationResource::collection($conversations);

        return Inertia::render('Forum/Index', compact('chanels', 'conversations'));
    }
}
