<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryPhoto extends Model
{
    protected $fillable = ['category_id', 'post_id'];
}
