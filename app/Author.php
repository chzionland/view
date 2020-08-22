<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;
use Spatie\Translatable\HasTranslations;

class Author extends Model
{
    use HasTranslations;

    protected $fillable = ['admin_id', 'thumbnail', 'name', 'slug', 'is_published'];

    public $translatable = ['name'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'author_posts');
    }
}
