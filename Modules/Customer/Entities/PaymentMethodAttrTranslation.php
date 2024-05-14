<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodAttrTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title'];
    protected $table = 'paymentmethod_attr_translations';

    
}
