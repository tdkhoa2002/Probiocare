<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrencyAttr extends Model
{
    use SoftDeletes;
    protected $table = 'wallet__currencyattrs';
    protected $fillable = [
        'blockchain_id',
        'currency_id',
        'token_address',
        'abi',
        'native_token',
        'decimal',
        'withdraw_fee_token',
        'withdraw_fee_token_type',
        'withdraw_fee_chain',
        'value_need_approve',
        'value_need_approve_currency',
        'max_amount_withdraw_daily',
        'max_amount_withdraw_daily_currency',
        'max_times_withdraw',
        'min_withdraw',
        'max_withdraw',
        'type_withdraw',
        'type_deposit',
        'type_transfer',
        'status'
    ];

    public function blockchain()
    {
        return $this->belongsTo(Blockchain::class, 'blockchain_id');
    }
    
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function nativeToken()
    {
        return $this->belongsTo(Currency::class, 'native_token');
    }
    public function valueNeedApproveCurrency()
    {
        return $this->belongsTo(Currency::class, 'value_need_approve_currency');
    }
    public function maxAmountWithdrawDailyCurrency()
    {
        return $this->belongsTo(Currency::class, 'max_amount_withdraw_daily_currency');
    }
}
