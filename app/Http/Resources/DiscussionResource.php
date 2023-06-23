<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscussionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only('id', 'title', 'slug') +
            [
                'is_pinned' => $this->isPinned(),
                'post' => PostResource::make($this->whenLoaded('post')),
                'user' => UserResource::make($this->whenLoaded('user')),
                'topic' => $this->whenLoaded('topic'),
                'latest_post' => PostResource::make($this->whenLoaded('latestPost')),
                'participants' => UserResource::collection($this->whenLoaded('participants'))
            ];
    }
}
