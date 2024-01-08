<?php

namespace Modules\Cryperrswap\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use Translatable;

    protected $table = 'cryperrswap__services';
    public $translatedAttributes = ['title'];
    protected $fillable = [
        'title',
        'code',
        'api_key',
        'serect_key',
        'status',
        'refcode','afftax'
    ];
}
