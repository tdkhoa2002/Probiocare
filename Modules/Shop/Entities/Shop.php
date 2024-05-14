<?php

namespace Modules\Shop\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use Translatable;

    protected $table = 'shop__shops';
    public $translatedAttributes = [];
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'description',
        'address',
        'country_id',
        'image_url',
        'status',
        'customer_id'
    ];
}
