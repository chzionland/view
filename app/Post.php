<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasTranslations;

    protected $fillable = ['admin_id', 'thumbnail', 'title', 'slug', 'sub_title', 'details', 'post_type', 'is_published'];

    public $translatable = ['title', 'sub_title', 'details'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_posts');
    }
}
