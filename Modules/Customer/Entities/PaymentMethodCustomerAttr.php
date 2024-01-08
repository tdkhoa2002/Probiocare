<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethodCustomerAttr extends Model
{
    use SoftDeletes;
    protected $table = 'paymentmethod_customerattrs';
    protected $fillable = [
        'payment_attr_id',
        'payment_customer_id',
        'value'
    ];
}
