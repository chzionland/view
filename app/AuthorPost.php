<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthorPost extends Model
{
    protected $fillable = ['author_id', 'post_id'];
}
