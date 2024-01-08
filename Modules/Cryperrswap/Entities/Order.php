<?php

namespace Modules\Cryperrswap\Entities;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'cryperrswap__orders';
    protected $fillable = [
        'order_code',
        'from_currency_id',
        'token_send',
        'address_order',
        'to_currency_id',
        'receive_order',
        'token_receive',
        'fee',
        'email',
        'type',
        'order_service_id',
        'status',
        'order_service_token',
        'to_hash', 'from_hash'
    ];
    const direction = ['from', 'to'];
    const type = ['fixed', 'float'];

    public function fromCurrency(){
        return $this->belongsTo(Currency::class,'from_currency_id');
    }
    
    public function toCurrency(){
        return $this->belongsTo(Currency::class,'to_currency_id');
    }
}
