<?php

namespace Modules\Trade\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TradeHistory extends Model
{
    use SoftDeletes;
    protected $table = 'trade__tradehistories';
    protected $fillable = [
        'trade_id',
        'amount',
        'amount_pair',
        'price',
        'fee',
        'fill',
        'trade_type',
        'is_maker'
    ];

    public function trade()
    {
        return $this->belongsTo(Trade::class, 'trade_id');
    }
}
