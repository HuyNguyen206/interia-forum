<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscussionResource;
use App\Models\Discussion;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index(Request $request)
    {
       return inertia()->render('Forum/Index', [
           'discussions' => DiscussionResource::collection(Discussion::query()
               ->when($request->no_reply, function (Builder $query){
                   $query->whereDoesntHave('posts');
               })
               ->with(['user', 'topic', 'post.user', 'latestPost.user', 'posts.user','participants' => function($query){
                   $query->limit(3);
               }])
               ->withCount(['participants', 'posts'])
               ->latest('pinned_at')
               ->orderBy(
                   Post::query()->select('created_at')->whereColumn('posts.discussion_id', 'discussions.id')
                   ->latest()
                   ->limit(1), 'desc'
               )
//               ->latest('created_at')
               ->paginate(1)->appends($queries = $request->query()))->additional(['queries' => $queries])
       ]);
    }
}
