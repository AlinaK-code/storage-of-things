<?php

namespace App\Events;

use App\Models\Thing;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ThingCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Thing $thing)
    {
    }

    public function broadcastOn()
    {
        return new Channel('thing-updates');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->thing->id,
            'name' => $this->thing->name,
           'owner' => $this->thing->owner?->name ?? '—',
        ];
    }
}