<?php

namespace Modules\MarketMaker\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Customer\Entities\Customer;
use Modules\Trade\Entities\Market;

class Volumnizer extends Model
{
    use SoftDeletes;

    protected $table = 'marketmaker__volumnizers';
    protected $fillable = [
        'market_id',
        'customer_id',
        'amount',
        'start_time',
        'end_time',
        'interval',
        'status',
        'checkpoint',
        'time_on_minutes'
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
