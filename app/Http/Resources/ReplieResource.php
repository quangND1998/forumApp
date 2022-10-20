<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\LikeResource;
use App\Http\Resources\UserResource;
class ReplieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
            [
                'id' => $this->id,
                'body' => $this->body,
                'slug' => $this->slug,
                'body_in_markdown' => $this->body_in_markdown,
                'best_answer' => $this->best_answer,
                'conversation_id' => $this->conversation_id,
                'owner' => new UserResource($this->user),
                'time_ago' => Carbon::parse($this->created_at)->diffForHumans(),
                'solved' => $this->solved,
                'likes' =>  $this->users->pluck('name'),
                'replie_id' => $this->replie_id,
                'user_reply' => $this->user_reply,
                'images' => $this->images,
                'videos'=> $this->videos

            ];
    }
}
