<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscussionResource;
use App\Http\Resources\PostResource;
use App\Models\Discussion;
use App\Models\Post;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Discussion $discussion)
    {
        return inertia()->render('Forum/Discussion/Show', [
            'discussion' => DiscussionResource::make($discussion->load('topic')),
            'posts' => PostResource::collection(Post::query()->with(['discussion', 'user'])->whereBelongsTo($discussion)->latest()->paginate(10))
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
