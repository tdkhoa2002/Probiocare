<?php

namespace Modules\Trade\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Customer\Entities\Customer;

class Trade extends Model
{
    use SoftDeletes;
    protected $table = 'trade__trades';
    protected $fillable = [
        'customer_id',
        'market_id',
        'amount',
        'amount_pair',
        'price_was',
        'total_fee',
        'fee',
        'fill',
        'trade_type',
        'order_id',
        'status',
    ];

    public function market()
    {
        return $this->belongsTo(Market::class, 'market_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
