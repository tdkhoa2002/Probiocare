<?php

namespace Modules\Staking\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Customer\Entities\Customer;
use Modules\Staking\Entities\PackageTerm;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'staking__orders';
    protected $fillable = [
        'code',
        'customer_id',
        'packageterm_id',
        'amount_stake',
        'amount_usd_stake',
        'subscription_date',
        'redemption_date',
        'last_time_reward',
        'total_amount_reward',
        'amount_reward',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
    public function term()
    {
        return $this->belongsTo(PackageTerm::class, 'packageterm_id');
    }
}
