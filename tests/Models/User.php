<?php

namespace Emincan\Tracker\Tests\Models;

use Emincan\Tracker\Trackable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Trackable;

    protected $guarded = [];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
