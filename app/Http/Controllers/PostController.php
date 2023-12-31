<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Post;
use App\Models\User;
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
//        dd($request->query());
        $this->authorize('reply', $discussion);

        $request->validate([
            'body' => 'required'
        ]);

        $post = $discussion->post->posts()->create([
            'user_id' => $request->user()->id,
            'discussion_id' => $discussion->id,
            'body' => $request->body,
        ]);

        preg_match_all('/\@(?P<username>[a-z-A-Z\-\_]+)/', $request->body, $mentionUsers, PREG_SET_ORDER);
        $userNames = collect($mentionUsers)->pluck('username');

        if (collect($userNames)) {
            $post->mentionUsers()->attach(User::query()->whereIn('username', $userNames)->pluck('id'));
        }
        
        return redirect()->route('discussions.show', [$discussion] + ['post_id' => $post->id]);
   }

   public function update(Request $request, Post $post)
    {
//        dd($request->query());
        $this->authorize('edit', $post);

        $request->validate([
            'body' => 'required'
        ]);

        $post->update([
            'body' => $request->body
        ]);

//        return redirect()->route('discussions.show', [$discussion] + ['post_id' => $post->id]);
   }

   public function destroy(Request $request, Post $post)
    {
//        dd($request->query());
        $this->authorize('delete', $post);

        $post->delete();

//        return redirect()->route('discussions.show', [$discussion] + ['post_id' => $post->id]);
   }
}
