<?php

namespace Modules\Wallet\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blockchain extends Model
{
    use SoftDeletes;
    protected $table = 'wallet__blockchains';
    protected $fillable = [
        'code',
        'title',
        'rpc',
        'scan',
        'native_token',
        'type',
        'wallet_receive',
        'chainid',
        'status',
    ];
}
