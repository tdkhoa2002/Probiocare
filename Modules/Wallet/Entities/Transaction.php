<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Customer\Entities\Customer;
use Modules\Wallet\Entities\Currency;
use Modules\Wallet\Entities\Blockchain;

class Transaction extends Model
{
    protected $table = 'wallet__transactions';
    protected $fillable = [
        'customer_id',
        'currency_id',
        'blockchain_id',
        'action',
        'amount',
        'amount_usd',
        'fee',
        'balance',
        'balanceBefore',
        'payment_method',
        'txhash',
        'from',
        'to',
        'tag',
        'order',
        'note',
        'status'
    ];

    public function blockchain()
    {
        return $this->belongsTo(Blockchain::class, 'blockchain_id');
    }
    
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
   
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}