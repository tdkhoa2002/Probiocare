<?php

namespace Modules\Peertopeer\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $table = 'peertopeer__orderhistories';
    protected $fillable = [
        'order_id',
        'customer_id',
        'paymentmethod_id',
        'amount',
        'note',
        'admin_note',
    ];
}