<?php

namespace Modules\Page\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;

class Category extends Model
{
    use Translatable, MediaRelation;

    protected $table = 'page__categories';

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
        'status',
        'title',
        'slug',
        'show_homepage',
        'sumary',
        'body',
        'parent_id',
        'meta_title',
        'meta_description',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
    ];

    public function getAvatar()
    {
        $thumbnail = $this->files()->where('zone', 'page_category_icon')->first();

        if ($thumbnail === null) {
            return '';
        }

        return $thumbnail;
    }

    public function parent()
    {
        return $this->belongsTo('Modules\Page\Entities\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Modules\Page\Entities\Category', 'parent_id');
    }

    public function pages()
    {
        return $this->belongsToMany('Modules\Page\Entities\Page');
    }
}
