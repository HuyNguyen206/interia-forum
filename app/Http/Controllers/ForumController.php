<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscussionResource;
use App\Models\Discussion;

class ForumController extends Controller
{
    public function index()
    {
       return inertia()->render('Forum/Index', [
           'discussions' => DiscussionResource::collection(Discussion::query()->with(['user', 'topic'])->latest('pinned_at')->latest('created_at')->paginate(10))
       ]);
    }
}
