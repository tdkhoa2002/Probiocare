<?php

namespace Modules\Wallet\Events;

use Illuminate\Queue\SerializesModels;

class IncreaseBalanceWallet
{
    use SerializesModels;
    public $amount;
    public $customerId;
    public $currencyId;
    public $action;
    public $orderId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($amount, $customerId, $currencyId, $action, $orderId)
    {
        $this->currencyId = $currencyId;
        $this->customerId = $customerId;
        $this->amount = $amount;
        $this->action = $action;
        $this->orderId = $orderId;
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
