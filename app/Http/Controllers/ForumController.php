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
           'discussions' => DiscussionResource::collection(
               Discussion::query()
               ->when($topic = $request->topic, function (Builder $query) use ($topic){
                   $query->whereHas('topic', function ($query) use ($topic) {
                       $query->where('slug', $topic);
                   });
               })
               ->when($request->boolean('mentioned'), function (Builder $query) {
                   $query->whereHas('posts', function (Builder $query) {
                       $query->whereHas('mentionUsers', function ($query){
                           $query->where('users.id', auth()->id());
                       });
                   });
               })
               ->when($request->has('solved'), function ($query) use ($request){
                   if ($request->boolean('solved')) {
                       $query->whereNotNull('best_reply_post_id');
                   } else {
                       $query->whereNull('best_reply_post_id');
                   }
               })
               ->when($request->no_reply, function (Builder $query){
                   $query->whereDoesntHave('posts');
               })
               ->when($request->my_discussion, function (Builder $query) use ($request){
                   $query->whereBelongsTo($request->user());
               })
               ->when($request->is_participant, function (Builder $query) use ($request){
                   $query->whereHas('posts', function ($query) use ($request){
                       $query->whereBelongsTo($request->user())
                             ->whereNotNull('post_parent_id');
                   });
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
               ->when($search = $request->search, function (Builder $query) use ($search) {
                  $query->whereIn('id', Discussion::search($search)->get()->pluck('id'));
               })
//               ->latest('created_at')
               ->paginate(10)->appends($queries = $request->query()))->additional(['queries' => $queries]),
            'search' => $request->search
       ]);
    }
}
