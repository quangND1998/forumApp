<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\LikeResource;
use App\Http\Resources\UserResource;
class LikeCommentEvent  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $replie;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($replie)
    {
        $this->replie = $replie;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('like_event');
    }
    public function broadcastWith()
    {
      
        return
            [
                'id' => $this->replie->id,
                'body' => $this->replie->body,
                'slug' => $this->replie->slug,
                'body_in_markdown' => $this->replie->body_in_markdown,
                'best_answer' => $this->replie->best_answer,
                'conversation_id' => $this->replie->conversation_id,
                'owner' => new UserResource($this->replie->user),
                'time_ago' => Carbon::parse($this->replie->created_at)->diffForHumans(),
                'solved' => $this->replie->solved,
                'likes' =>  LikeResource::collection($this->replie->users),
                'replie_id' => $this->replie->replie_id,
                'replie_user' => $this->replie->replie_user,
                'user_reply' => $this->replie->user_reply

            ];
    }
}
