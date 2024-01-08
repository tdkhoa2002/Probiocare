<?php

namespace Modules\Staking\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Commission extends Model
{
    use SoftDeletes;

    protected $table = 'staking__commissions';
    protected $fillable = [
        'package_id',
        'level',
        'commission',
        'type',
        'status'
    ];
}