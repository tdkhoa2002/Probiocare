<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;

class ShopTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'shop__shop_translations';
}
