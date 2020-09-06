<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{
    use HasTranslations;

    protected $fillable = ['admin_id', 'name', 'slug'];

    public $translatable = ['name'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'tag_posts');
    }

    public function photos()
    {
        return $this->belongsToMany(Photo::class, 'tag_photos');
    }
}
