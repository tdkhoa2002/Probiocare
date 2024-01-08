<?php

namespace Modules\Wallet\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class CrawlHistory extends Model
{
    protected $table = 'wallet__crawlhistories';
    protected $fillable = [
        'walletchain_id',
        'crawldeposit_id',
        'amount',
        'txhash',
    ];

    public function walletChain()
    {
        return $this->belongsTo(WalletChain::class, 'walletchain_id');
    }
}
