<?php

namespace Modules\Wallet\Events;

use Illuminate\Queue\SerializesModels;

class UpdateBalanceWallet
{
    use SerializesModels;
    public $balance;
    public $walletId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($balance, $walletId)
    {
        $this->balance = $balance;
        $this->walletId = $walletId;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
