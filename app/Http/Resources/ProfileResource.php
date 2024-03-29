<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProfileResource extends JsonResource
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
                'email' => $this->email,
                'name' => $this->name,
                'avatar' => $this->avatar ? $this->avatar : 'https://ui-avatars.com/api/?name=' . Str::slug($this->name) . '?background=0D8ABC&color=fff',
                // 'replies' => ReplieResource::collection($this->replies),
                'time_ago' => Carbon::parse($this->created_at)->diffForHumans(),
                'address' => $this->address,
                'about_you' => $this->about_you,
                'country' => $this->country,
                // 'conversations' => ConversationResource::collection($this->conversations)
            ];
    }
}
