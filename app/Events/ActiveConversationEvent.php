<?php

namespace App\Events;

use App\Http\Resources\LastReplieResource;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
class ActiveConversationEvent implements ShouldBroadcast
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
        return new Channel('active-conversation');
    }

    public function broadcastWith()
    {

        return
            [
                'id' => $this->conversation->id,
                'title' => $this->conversation->title,
                'sub_body' => Str::words(strip_tags($this->conversation->body)),
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
                'active' => $this->conversation->active ==0? false: true,
                'lastReplie' =>  $this->conversation->lastReplie ==null ? null:new LastReplieResource($this->conversation->lastReplie)
            ];
    }
}
