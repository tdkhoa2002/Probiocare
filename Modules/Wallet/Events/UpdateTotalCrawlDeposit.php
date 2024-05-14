<?php

namespace Modules\Wallet\Events;

use Illuminate\Queue\SerializesModels;

class UpdateTotalCrawlDeposit
{
    use SerializesModels;
    public $crawlDepositId;
    public $amount;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($crawlDepositId,$amount)
    {
        $this->crawlDepositId = $crawlDepositId;
        $this->amount = $amount;
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
