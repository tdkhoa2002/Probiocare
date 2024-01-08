<?php

namespace Modules\Customer\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Wallet\Entities\Wallet;
use Modules\Peertopeer\Entities\Ads;

class Customer extends Authenticatable
{
    use Notifiable, SoftDeletes;
    protected $table = 'customer__customers';
    protected $fillable = [
        'email',
        'password',
        'ref_code',
        'gg_auth',
        'status_gg_auth',
        'status_kyc',
        'sponsor_id',
        'sponsor_floor',
        'is_agent',
        'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function avatar()
    {
        return $this->filesByZone('CUSTOMER_AVATAR')->first();
    }
    
    public function profile()
    {
        return $this->hasOne(CustomerProfile::class, 'customer_id');
    }

    public function kyc()
    {
        return $this->hasOne(CustomerKyc::class, 'customer_id');
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class, 'customer_id');
    }

    public function ads()
    {
        return $this->hasMany(Ads::class, 'customer_id');
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethodCustomer::class, 'customer_id');
    }

    public function apiTokens()
    {
        return $this->hasMany(CustomerApiKey::class, 'customer_id');
    }
}
