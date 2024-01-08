<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerSocial extends Model
{
    use SoftDeletes;
    protected $table = 'customer__customersocials';
    protected $fillable = [
        'customer_id',
        'provider_customer_id',
        'provider_customer_token',
        'provider',
    ];
}
