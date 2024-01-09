<?php

namespace Modules\Product\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;

class Category extends Model
{
    use Translatable,MediaRelation;

    protected $table = 'product__categories';
    public $translatedAttributes = [
        'category_id',
        'title',
        'slug',
        'sumary',
        'body',
        'meta_title',
        'meta_description',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
    ];
    protected $fillable = [
        'parent_id',
        'status',
        'title',
        'slug',
        'show_homepage',
        'show_sidebar',
        'show_menu',
        'sumary',
        'body',
        'meta_title',
        'meta_description',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
    ];

    public function getAvatar()
    {
        $thumbnail = $this->files()->where('zone', 'avatar')->first();
        if ($thumbnail === null) {
            return '';
        }
        return $thumbnail;
    }

    
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
