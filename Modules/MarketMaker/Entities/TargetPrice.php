<?php

namespace Modules\MarketMaker\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Customer\Entities\Customer;
use Modules\Trade\Entities\Market;

class TargetPrice extends Model
{
    use SoftDeletes;
    protected $table = 'marketmaker__targetprices';
    protected $fillable = [
        'market_id',
        'customer_id',
        'price',
        'amount',
        'status',
        'schedule'
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
