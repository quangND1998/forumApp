<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class ActivitiesResources extends JsonResource
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
            'heading' => $this->heading,
            'icon' => $this->icon,
            'pointsEarned' => $this->pointsEarned,
            'type' => $this->type,
            'createdDiff' => Carbon::parse($this->created_at)->diffForHumans(),
            'subject' => $this->subject,
            'owner' => new UserResource($this->user),
        ];
    }
}
