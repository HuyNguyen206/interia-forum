<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only('id', 'body') + [
                'body_markdown' => $this->body ? app(MarkdownRenderer::class)->highlightTheme('nord')->toHtml($this->body) : null,
                'created_at' => $this->created_at?->diffForHumans(),
                'body_preview' => Str::limit($this->body),
                'user' => UserResource::make($this->whenLoaded('user')),
                'discussion' => DiscussionResource::make($this->whenLoaded('discussion')),
                'can' => [
                    'edit' =>  $request->user()?->can('edit', $this->resource),
                    'delete' => $request->user()?->can('delete', $this->resource),
                    'mark_best_reply' => $request->user()?->can('toggleBestReply', [$this->resource, $request->discussion]),
                ]
            ];
    }
}
