<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'customer__countries';
    protected $fillable = [
        'country_code', 'country_name'
    ];
}
