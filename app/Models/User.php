<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasEagerLimit, Searchable;

    protected $appends = ['avatar'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function avatar(): Attribute
    {
        return Attribute::get(fn() => 'https://www.gravatar.com/avatar/'. md5($this->email));
    }

    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    public function toSearchableArray()
    {
        return [
            'label' => $this->name . "(@{$this->username})",
            'value' => $this->username
        ];
    }

    public function mentionPosts()
    {
        return $this->belongsToMany(Post::class, 'mentions')->withTimestamps();
    }
}
