<?php

namespace App\Events;

use App\Models\ManualOrder;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ManualOrderCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $manualOrder;

    /**
     * Create a new event instance.
     */
    public function __construct(ManualOrder $manualOrder)
    {
        $this->manualOrder = $manualOrder;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
