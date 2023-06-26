<?php

namespace App\Http\Resources;

use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class DiscussionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->only('id', 'title', 'slug') +
            [
                'is_pinned' => $this->isPinned(),
                'post' => PostResource::make($this->whenLoaded('post')),
                'posts_count' => $this->posts_count. ' '. Str::plural('reply', $this->posts_count),
                'user' => UserResource::make($this->whenLoaded('user')),
                'topic' => $this->whenLoaded('topic'),
                'latest_post' => PostResource::make($this->whenLoaded('latestPost')),
                'participants' => UserResource::collection($this->whenLoaded('participants')),
                'can' => [
                    'create' => $request->user()->can('create', Discussion::class),
                    'reply' => $request->user()->can('reply', $this->resource),
                ]
            ];

        if ($this->relationLoaded('participants')) {
            $hasMore = $this->participants_count > 3;
            $data['remain_participant_count'] = $hasMore ? $this->participants_count - 3 : 0;
            $data['has_more_participant'] =  $hasMore;
        }

        return $data;
    }
}
