<?php

namespace Modules\Wallet\Events;

use Illuminate\Queue\SerializesModels;

class UpdateTransaction
{
    use SerializesModels;
    public $transactionId;
    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($transactionId, $data)
    {
        $this->data = $data;
        $this->transactionId = $transactionId;
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
