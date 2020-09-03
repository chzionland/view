<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Photo extends Model
{
    use HasTranslations;
    protected $fillable = ['admin_id', 'image_url', 'intro', 'is_published'];
    public $translatable = ['intro'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_photos');
    }
}
