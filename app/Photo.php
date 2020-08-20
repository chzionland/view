<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['admin_id', 'image_url'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
