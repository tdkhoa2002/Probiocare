<?php

namespace Modules\Trade\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HookMarketInfo implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $dataInfo;
    public function __construct($dataInfo)
    {
        $this->dataInfo = $dataInfo;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn(): Channel
    {
        return new Channel('Market.info');
    }

    public function broadcastAs()
    {
        return 'HookMarketInfo';
    }
}
