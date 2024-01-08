<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use MediaRelation, SoftDeletes;
    protected $table = 'wallet__currencies';
    protected $fillable = [
        'code',
        'title',
        'type',
        'min_crawl',
        'transfer_fee',
        'transfer_fee_type',
        'swap_enable',
        'swap_fee',
        'swap_fee_type',
        'min_swap',
        'max_swap',
        'usd_rate',
        'link_rate',
        'total_supply',
        'status'
    ];

    public function getIcon()
    {
        return $this->filesByZone('CURRENCY_ICON')->first();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'currency_id');
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class, 'currency_id');
    }
}
