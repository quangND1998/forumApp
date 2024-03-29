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
                'best_answer' => $this->replie->best_answer,
                'likes' =>  $this->replie->users->pluck('name'),
                'replie_id' => $this->replie->replie_id,

            ];
    }
}
