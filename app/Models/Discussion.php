<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Discussion extends Model
{
    use HasFactory, HasEagerLimit, Searchable;

    protected static function booted()
    {
        static::created(function (Discussion $discussion){
           $discussion->slug = $discussion->id . '-' . Str::slug($discussion->title);
           $discussion->save();
        });
    }

    public function isPinned()
    {
        return (bool) $this->pinned_at;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function post()
    {
        return $this->hasOne(Post::class)->original()->withDefault();
    }

    public function latestPost()
    {
       return $this->hasOne(Post::class)->latestOfMany();
    }

    public function participants()
    {
        return $this->hasManyThrough(User::class, Post::class, 'discussion_id', 'id', 'id', 'user_id')
            ->orderByRaw('max(posts.created_at) asc')
            ->addselect(['users.id', 'users.email', 'users.username'])
            ->groupBy('users.id', 'users.email', 'users.username', 'posts.discussion_id');
    }

    public function bestReply()
    {
        return $this->belongsTo(Post::class, 'best_reply_post_id');
    }

    public function toSearchableArray()
    {
        return $this->only(['title', 'id']);
    }

}
