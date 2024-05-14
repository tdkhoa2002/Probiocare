<?php

namespace Modules\Wallet\Entities;
use Illuminate\Database\Eloquent\Model;

class TransactionCode extends Model
{
    protected $table = 'wallet__transactioncodes';
    protected $fillable = [
        'transaction_id',
        'code',
        'type',
        'expired_at'
    ];
}
