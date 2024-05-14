<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletChain extends Model
{
    use SoftDeletes;
    protected $table = 'wallet__walletchains';
    protected $fillable = [
        'address',
        'addressTag',
        'private_key',
        'blockchain_id',
        'wallet_id',
        'onhold',
        'is_sync',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }
    
    public function blockchain()
    {
        return $this->belongsTo(Blockchain::class, 'blockchain_id');
    }
}
