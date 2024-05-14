<?php

namespace Modules\Customer\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Support\Traits\MediaRelation;

class PaymentMethod extends Model
{
    use Translatable, SoftDeletes, MediaRelation;

    protected $table = 'paymentmethods';
    public $translatedAttributes = ['title'];
    protected $translationForeignKey = 'paymentmethod_id';
    protected $fillable = ['title'];

    public function logo()
    {
        return $this->filesByZone('PAYMEN_METHOD_LOGO')->first();
    }

    public function attrs()
    {
        return $this->hasMany(PaymentMethodAttr::class, 'paymentmethod_id');
    }
}
