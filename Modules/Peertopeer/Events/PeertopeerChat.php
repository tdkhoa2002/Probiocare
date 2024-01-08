<?php

namespace Modules\Peertopeer\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PeertopeerChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $orderId;
    public function __construct($message)
    {
        $this->message = $message;
        $this->orderId = $message->order_id;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn(): Channel
    {
        return new Channel('private-chat-'.$this->orderId);
    }

    public function broadcastAs()
    {
        return 'PeertopeerChat';
    }
}
