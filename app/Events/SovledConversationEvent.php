<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SovledConversationEvent  implements ShouldBroadcast
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
        return new Channel('sovled-conversation');
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
                'lock_comment' => $this->conversation->lock_comment == 0 ? false : true,
                'body_in_markdown' => $this->conversation->body_in_markdown,
                'chanel_id' => $this->conversation->chanel_id,
                'solved' => $this->conversation->solved,
            ];
    }
}
