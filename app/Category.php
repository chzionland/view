<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;

    protected $fillable = ['admin_id', 'thumbnail', 'name', 'slug', 'is_column', 'is_published'];

    public $translatable = ['name'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_posts');
    }

    public function photos()
    {
        return $this->belongsToMany(Photo::class, 'category_posts');
    }
}
