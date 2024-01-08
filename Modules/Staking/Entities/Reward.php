<?php

namespace Modules\Staking\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use SoftDeletes;

    protected $table = 'staking__rewards';
    protected $fillable = [
        'packageterm_id',
        'currency_reward_id',
        'apr_reward',
        'status',
    ];
}