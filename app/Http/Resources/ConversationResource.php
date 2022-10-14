<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\UserResource;
use App\Http\Resources\LastReplieResource;
use Illuminate\Support\Str;
class ConversationResource extends JsonResource
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
                'title' => $this->title,
                'body' => $this->body,
                'slug' => $this->slug,
                'view' => $this->view,
                'lock_comment' => $this->lock_comment ==0? false: true,
                'body_in_markdown' => $this->body_in_markdown,
                'chanel_id' => $this->chanel_id,
                'owner' => new UserResource($this->user),
                'chanel' => $this->chanel,
                'count_reply' => count($this->all_replies),
                'created_at' => $this->created_at,
                'now' => Carbon::now(),
                'time_ago' => Carbon::parse($this->created_at)->diffForHumans(),
                'solved' => $this->solved,
                'sub_body' => Str::words(strip_tags($this->body)),
                // 'lastReplie' => $this->lastReplie
                'lastReplie' => new LastReplieResource($this->lastReplie)



            ];
    }
}
