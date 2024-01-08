<?php

namespace Modules\Wallet\Events;

use Illuminate\Queue\SerializesModels;

class ResetOnHoldWalletChain
{
    use SerializesModels;
    public $walletId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($walletId)
    {
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
