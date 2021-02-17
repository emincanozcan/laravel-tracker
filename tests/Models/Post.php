<?php

namespace Emincan\Tracker\Tests\Models;

use Emincan\Tracker\Trackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  use HasFactory, Trackable;
  protected $guarded = [];

  public function tags()
  {
    return $this->hasMany(Tag::class);
  }
}
