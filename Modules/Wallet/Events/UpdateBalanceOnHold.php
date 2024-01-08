<?php

namespace Modules\Wallet\Events;

use Illuminate\Queue\SerializesModels;

class UpdateBalanceOnHold
{
    use SerializesModels;
    public $amount;
    public $wallet_id;
    public $blockchain_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($amount, $wallet_id, $blockchain_id)
    {
        $this->amount = $amount;
        $this->wallet_id = $wallet_id;
        $this->blockchain_id = $blockchain_id;
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
