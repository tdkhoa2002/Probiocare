<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerHistory extends Model
{
    use SoftDeletes;
    
    protected $table = 'customer__customerhistories';
    protected $fillable = [
        'customer_id',
        'ip',
        'os',
        'action',
        'device_id',
        'data_request'
    ];
}
