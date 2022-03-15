<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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
                'conversation_id' => $this->conversation_id,
                'owner' => new UserResource($this->user),
                'time_ago' => Carbon::parse($this->created_at)->diffForHumans(),
                'solved' => $this->solved,
               

            ];
    }
}
