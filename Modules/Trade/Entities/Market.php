<?php

namespace Modules\Trade\Entities;

use Modules\Trade\Entities\TradeHistory;
use Modules\Trade\Entities\Trade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Wallet\Entities\Currency;

class Market extends Model
{
    use SoftDeletes;
    protected $table = 'trade__markets';
    protected $fillable = [
        'symbol',
        'currency_id',
        'currency_pair_id',
        'type',
        'taker',
        'maker',
        'min_amount',
        'max_amount',
        'price',
        'price_usd',
        'price_change_24h',
        'hight_24h',
        'low_24h',
        'volume_24h',
        'volume_pair_24h',
        'status',
        'service_base_code',
        'service_base_id',
        'service_quote_code',
        'service_quote_id',
        'service_customer_id'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function currencyPair()
    {
        return $this->belongsTo(Currency::class, 'currency_pair_id');
    }

    public function tradeHistories()
    {
        return $this->hasManyThrough(TradeHistory::class, Trade::class, 'market_id', 'trade_id');
    }
}
