<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Post extends Model
{
    use HasFactory, HasEagerLimit;

    public function scopeOriginal($builder)
    {
        $builder->whereNull('post_parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parentPost()
    {
            $this->belongsTo(Post::class, 'post_parent_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'post_parent_id');
    }

    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }
}
