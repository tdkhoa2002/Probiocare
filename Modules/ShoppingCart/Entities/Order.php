<?php

namespace Modules\ShoppingCart\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'shoppingcart__orders';
    protected $fillable = [
        'order_code',
        'payment_code',
        'fullname',
        'email',
        'phone_number',
        'address',
        'note',
        'total',
        'time_ship',
        'payment_method',
        'delivery_method',
        'status'
    ];
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
