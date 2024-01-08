<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title'];
    protected $table = 'paymentmethod_translations';
}
