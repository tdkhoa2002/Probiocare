<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Model;

class ChainWallet extends Model
{
    protected $table = 'wallet__chainwallets';
    protected $fillable = [
        'blockchain_id',
        'address',
        'private_key',
        'using',
        'status',
    ];

    public function blockchain()
    {
        return $this->belongsTo(Blockchain::class, 'blockchain_id');
    }
}
