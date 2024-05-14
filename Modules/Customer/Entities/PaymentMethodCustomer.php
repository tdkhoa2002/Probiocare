<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethodCustomer extends Model
{
    use SoftDeletes;
    protected $table = 'paymentmethod_customers';
    protected $fillable = ['paymentmethod_id', 'customer_id'];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'paymentmethod_id');
    }

    public function paymentMethodCustomerAttr()
    {
        return $this->hasMany(PaymentMethodCustomerAttr::class, 'payment_customer_id');
    }
}
