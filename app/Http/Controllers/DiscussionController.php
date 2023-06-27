<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscussionResource;
use App\Http\Resources\PostResource;
use App\Models\Discussion;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Discussion::class);

        $data = $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required', 'max:1000'],
            'topic_id' => ['required', 'numeric', Rule::exists('topics', 'id')],
        ]);

        $discussion = $request->user()->discussions()->create(Arr::except($data, ['body']));

        $discussion->posts()->create([
            'user_id' => $request->user()->id,
            'body' => $request->body,
        ]);

        return redirect()->route('discussions.show', $discussion);

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Discussion $discussion)
    {
        $currentPage = null;
        if ($postId = $request->post_id) {
            $offset = Post::query()->whereBelongsTo($discussion)->where('id', '<=', $postId)->orderBy('id')->count();
            $currentPage = ceil($offset / 5);

            return redirect(route('discussions.show',['discussion' => $discussion, 'page' => $currentPage]));
        }

        return inertia()->render('Forum/Discussion/Show', [
            'discussion' => DiscussionResource::make($discussion->load('topic')->loadCount('posts')),
            'posts' => PostResource::collection(Post::query()->with(['discussion', 'user'])->whereBelongsTo($discussion)->oldest('id')->paginate(5, page:$currentPage))
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discussion $discussion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discussion $discussion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discussion $discussion)
    {
        //
    }
}
