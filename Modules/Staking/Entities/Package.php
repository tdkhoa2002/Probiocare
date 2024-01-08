<?php

namespace Modules\Staking\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Wallet\Entities\Currency;
use Modules\Staking\Entities\PackageTerm;

class Package extends Model
{
    use Translatable, SoftDeletes;

    protected $table = 'staking__packages';
    public $translatedAttributes = [
        'title',
        'description'
    ];
    protected $fillable = [
        'hour_reward',
        'currency_stake_id',
        'currency_reward_id',
        'min_stake',
        'max_stake',
        'start_date',
        'end_date',
        'status',
        'title',
        'description',
        'principal_is_stake_currency',
    ];

    public function currencyStake()
    {
        return $this->belongsTo(Currency::class, 'currency_stake_id');
    }

    public function currencyReward()
    {
        return $this->belongsTo(Currency::class, 'currency_reward_id');
    }

    public function terms()
    {
        return $this->hasMany(PackageTerm::class, 'package_id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'package_id');
    }
}
