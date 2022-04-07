<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use App\Http\Resources\LikeResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\LastReplieResource;
class ViewConversationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $conversation;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('view_conversation_event');
    }

    public function broadcastWith()
    {   
        
        return
        [
            'id' => $this->conversation->id,
            'title' => $this->conversation->title,
            'body' => $this->conversation->body,
            'slug' => $this->conversation->slug,
            'view' => $this->conversation->view,
            'lock_comment' => $this->conversation->lock_comment ==0? false: true,
            'body_in_markdown' => $this->conversation->body_in_markdown,
            'chanel_id' => $this->conversation->chanel_id,
            'owner' => new UserResource($this->conversation->user),
            'chanel' => $this->conversation->chanel,
            'count_reply' => count($this->conversation->all_replies),
            'created_at' => $this->conversation->created_at,
            'now' => Carbon::now(),
            'time_ago' => Carbon::parse($this->conversation->created_at)->diffForHumans(),
            'solved' => $this->conversation->solved,
            'lastReplie' =>  $this->conversation->lastReplie ==null ? null:new LastReplieResource($this->conversation->lastReplie)
        ];
    }
}
