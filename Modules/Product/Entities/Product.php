<?php

namespace Modules\Product\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;

class Product extends Model
{
    use Translatable, MediaRelation;

    protected $table = 'product__products';
    public $translatedAttributes = [
        'title',
        'slug',
        'sumary',
        'product_info',
        'meta_title',
        'meta_description',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
    ];
    protected $fillable = [
        'category_id',
        'status',
        'show_homepage',
        'is_best_selling',
        'is_new_arrivals',
        'is_best_choice',
        'is_promotion',
        'total_sold',
        'code',
        'price',
        'price_member',
        'price_sale',
        'title',
        'slug',
        'sumary',
        'product_status',
        'product_info',
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

    public function getImages()
    {
        $thumbnail = $this->files()->where('zone', 'slider_product')->get();
        if ($thumbnail === null) {
            return [];
        }
        return $thumbnail;
    }
}
