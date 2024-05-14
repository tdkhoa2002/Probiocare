<?php

namespace Modules\Affiliate\Entities;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    protected $table = 'affiliate__affiliates';
    protected $fillable = [
        'level',
        'commission',
        'commission_type',
        'type',
        'status',
    ];
}