<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerDevice extends Model
{
    use SoftDeletes;
    protected $table = 'customer__customerdevices';
    protected $fillable = [
        'customer_id',
        'player_id',
        'device_type',
    ];
}