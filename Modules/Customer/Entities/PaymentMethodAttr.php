<?php

namespace Modules\Customer\Entities;

use Modules\Customer\Entities;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethodAttr extends Model
{
    use Translatable, SoftDeletes;

    protected $table = 'paymentmethod_attrs';
    public $translatedAttributes = ['title'];
    protected $translationForeignKey = 'payment_attr_id';
    protected $fillable = ['title', 'paymentmethod_id', 'is_require','type', 'is_show'];
}
