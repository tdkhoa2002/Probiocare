<?php

namespace Modules\Loyalty\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'loyalty__order_translations';
}
