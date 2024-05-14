<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;

class CrawlDeposit extends Model
{
    protected $table = 'wallet__crawldeposits';
    protected $fillable = [
        'blockchain_id',
        'currency_id',
        'user_id',
        'total',
    ];

    public function crawlHistories()
    {
        return $this->hasMany(CrawlHistory::class, 'crawldeposit_id');
    }

    public function blockchain()
    {
        return $this->belongsTo(Blockchain::class, 'blockchain_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
