<?php

namespace Modules\Trade\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HookTradeMarket implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $symbol;
    public $dataTrade;
    public function __construct($symbol, $dataTrade)
    {
        $this->dataTrade = $dataTrade;
        $this->symbol = $symbol;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn(): Channel
    {
        return new Channel('Market.' . $this->symbol);
    }

    public function broadcastAs()
    {
        return 'HookTradeMarket';
    }
}
