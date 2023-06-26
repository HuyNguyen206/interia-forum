<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class PostController extends Controller
{
    public function previewMarkdown(Request $request)
    {
        $request->validate([
            'body' => 'required'
        ]);

        return app(MarkdownRenderer::class)->highlightTheme('nord')->toHtml($request->body);
   }

    public function store(Request $request, Discussion $discussion)
    {
        $this->authorize('reply', $discussion);

        $request->validate([
            'body' => 'required'
        ]);

        $discussion->post->posts()->create([
            'user_id' => $request->user()->id,
            'discussion_id' => $discussion->id,
            'body' => $request->body,
        ]);

        return redirect()->route('discussions.show', $discussion);
   }
}
