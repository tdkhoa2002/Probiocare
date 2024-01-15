<?php

namespace Modules\Loyalty\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use SoftDeletes;

    protected $table = 'loyalty__rewards';
    protected $fillable = [
        'packageterm_id',
        'currency_reward_id',
        'apr_reward',
        'status',
    ];
}