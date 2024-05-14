<?php

namespace Modules\Product\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;

class Category extends Model
{
    use MediaRelation;

    protected $table = 'product__categories';
    public $translatedAttributes = [
    ];
    protected $fillable = [
        'parent_id',
        'title',
        'status',
        'description'
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
