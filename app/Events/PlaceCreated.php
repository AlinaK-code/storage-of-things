<?php

namespace App\Events;

use App\Models\Place;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class PlaceCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Place $place)
    {
    }

    public function broadcastOn()
    {
        return new Channel('place-updates');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->place->id,
            'name' => $this->place->name,
            'owner' => $this->place->owner?->name ?? '—',
        ];
    }
}