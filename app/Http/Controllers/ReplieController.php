<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConversationResource;
use App\Http\Resources\InitalReplieResource;
use App\Models\Chanels;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\ReplieResource;

class ReplieController extends Controller
{

    public function getDetail($name)
    {

        $conversation = Conversation::with('user', 'all_replies', 'initalReplies.user.replies',  'chanel')->where('slug', $name)->first();
        // return $conversation;
        // $conversation = new ConversationResource($conversation);
        // return $conversation;

        if ($conversation !== null) {
            // return $conversation->initalReplies;
            $initalReplies = InitalReplieResource::collection($conversation->initalReplies);

            $conversation = new ConversationResource($conversation);
            return Inertia::render('Forum/Replie', compact('conversation', 'initalReplies'));
        } else {
            $erros = "Not found conversation !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }
}
