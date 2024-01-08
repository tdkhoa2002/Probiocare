<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Support\Traits\MediaRelation;

class CustomerKyc extends Model
{
    use MediaRelation, SoftDeletes;

    protected $table = 'customer__customerkycs';
    protected $fillable = [
        'customer_id',
        'number',
        'type',
        'reason',
        'country_id',
        'first_name',
        'last_name',
        'birthday'
    ];

    public function imageFront()
    {
        return $this->filesByZone('CUSTOMER_KYC_FRONT')->first();
    }

    public function imageBack()
    {
        return $this->filesByZone('CUSTOMER_KYC_BACK')->first();
    }

    public function imageSelfie()
    {
        return $this->filesByZone('CUSTOMER_KYC_SELFIE')->first();
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
