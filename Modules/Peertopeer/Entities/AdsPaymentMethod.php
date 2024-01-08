<?php

namespace Modules\Peertopeer\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AdsPaymentMethod extends Model
{
    protected $table = 'peertopeer__adspaymentmethods';
    protected $fillable = [];
}
