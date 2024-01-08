<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Customer\Entities\Customer;
use Modules\Wallet\Entities\Currency;

class Wallet extends Model
{
    protected $table = 'wallet__wallets';
    protected $fillable = [
        'customer_id',
        'currency_id',
        'type',
        'balance',
        'status',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function walletChains()
    {
        return $this->hasMany(WalletChain::class, 'wallet_id');
    }
}
