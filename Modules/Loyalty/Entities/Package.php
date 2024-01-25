<?php

namespace Modules\Loyalty\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Wallet\Entities\Currency;
use Modules\Loyalty\Entities\PackageTerm;
use Modules\Media\Support\Traits\MediaRelation;

class Package extends Model
{
    use Translatable, SoftDeletes, MediaRelation;

    protected $table = 'loyalty__packages';
    public $translatedAttributes = [
        'title',
        'description'
    ];
    protected $fillable = [
        'hour_reward',
        'currency_stake_id',
        'currency_reward_id',
        'currency_cashback_id',
        'min_stake',
        'max_stake',
        'start_date',
        'end_date',
        'status',
        'title',
        'description',
        'principal_is_stake_currency',
        'require_entry',
        'term_matching',
        'principal_convert_rate'
    ];

    public function currencyStake()
    {
        return $this->belongsTo(Currency::class, 'currency_stake_id');
    }

    public function currencyReward()
    {
        return $this->belongsTo(Currency::class, 'currency_reward_id');
    }

    public function currencyCashback()
    {
        return $this->belongsTo(Currency::class, 'currency_cashback_id');
    }

    public function terms()
    {
        return $this->hasMany(PackageTerm::class, 'package_id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'package_id');
    }

    public function getIcon()
    {
        return $this->filesByZone('PACKAGE_ICON')->first();
    }
}
