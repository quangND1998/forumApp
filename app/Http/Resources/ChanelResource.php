<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChanelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'title' => $this->title,
            'description'=>$this->description,
            'slug' =>$this->slug,
            'color' => $this->color,
            'conversations_count' => $this->conversations_count,
            'last_conversation' => new ConversationResource($this->lastConversation)
        ];
    }
}
