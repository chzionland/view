<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasTranslations;
    protected $fillable = [
        'admin_id', 'thumbnail', 'title', 'slug', 'sub_title',
        'is_top', 'is_reproduced', 'source', 'source_url', 'editor',
        'intro', 'details', 'post_type', 'is_published',
    ];
    public $translatable = ['title', 'sub_title', 'intro', 'details'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_posts');
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'author_posts');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_posts');
    }
}
