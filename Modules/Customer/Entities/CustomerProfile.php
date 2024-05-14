<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerProfile extends Model
{
    use SoftDeletes;
    protected $table = 'customer__customerprofiles';
    protected $fillable = [
        'customer_id',
        'firstname',
        'lastname',
        'phone_number',
        'country_id',
        'address',
        'birthday',
    ];
    protected $appends = ['full_name'];
    public function getFullNameAttribute()
    {
        return $this->lastname . ' ' . $this->firstname;
    }
}
