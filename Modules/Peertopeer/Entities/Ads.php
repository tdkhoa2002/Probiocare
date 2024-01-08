<?php

namespace Modules\Peertopeer\Entities;

use Modules\Peertopeer\Entities\AdsPaymentMethod;
use Modules\Customer\Entities\PaymentMethod;
use Modules\Customer\Entities\Customer;
use Modules\Wallet\Entities\Currency;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Customer\Entities\PaymentMethodCustomer;

class Ads extends Model
{
    protected $table = 'peertopeer__ads';
    protected $fillable = [
        'customer_id',
        'fiat_currency_id',
        'asset_currency_id',
        'fixed_price',
        'total_filled',
        'total_trade_amount',
        'order_limit_min',
        'order_limit_max',
        'payment_time_limit',
        'type',
        'term',
        'auto_reply',
        'status',
        'require_kyc',
        'require_registered',
        'require_registered_day',
        'require_holding',
        'require_holding_amount'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'asset_currency_id');
    }

    public function currencyFiat()
    {
        return $this->belongsTo(Currency::class, 'fiat_currency_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethodCustomer::class, 'peertopeer__adspaymentmethods', 'ads_id', 'paymentmethod_id');
    }
}
