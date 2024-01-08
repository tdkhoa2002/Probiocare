<?php

namespace Modules\Peertopeer\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Entities\PaymentMethod;
use Modules\Customer\Entities\PaymentMethodCustomer;
use Modules\Peertopeer\Entities\Ads;
use Modules\Wallet\Entities\Currency;

class Order extends Model
{
    protected $table = 'peertopeer__orders';
    protected $fillable = [
        'code',
        'ads_id',
        'customer_id',
        'paymentmethod_id',
        'total_fiat_amount',
        'total_asset_amount',
        'type',
        'room_id',
        'status',
        'seller_id', 'buyer_id', 'fiat_currency_id', 'asset_currency_id','fixed_price'
    ];
   
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function seller()
    {
        return $this->belongsTo(Customer::class, 'seller_id');
    }

    public function ad()
    {
        return $this->belongsTo(Ads::class, 'ads_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethodCustomer::class, 'paymentmethod_id');
    }

    public function assetCurrency()
    {
        return $this->belongsTo(Currency::class, 'asset_currency_id');
    }

    public function fiatCurrency()
    {
        return $this->belongsTo(Currency::class, 'fiat_currency_id');
    }

}
