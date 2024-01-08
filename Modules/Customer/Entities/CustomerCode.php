<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class CustomerCode extends Model
{
    protected $table = 'customer__customercodes';
    protected $fillable = [
        'customer_id',
        'code',
        'type',
        'expired_at'
    ];
}

