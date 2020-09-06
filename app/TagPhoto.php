<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagPhoto extends Model
{
    protected $fillable = ['tag_id', 'photo_id'];
}
