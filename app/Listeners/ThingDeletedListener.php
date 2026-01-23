<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Archive;
use App\Models\Thing;
use Illuminate\Support\Facades\Auth;

class ThingDeletedListener
{
    public function handle($event)
    {
        $thing = $event->thing;

        if (!$thing) {
            return;
        }

        $name = $thing->name ?? 'Без названия';
        $wrnt = $thing->wrnt ?? null;
        $unitSymbol = optional($thing->unit)->symbol;

        $ownerName = optional($thing->owner)->name;
        $ownerId = $thing->master ?? null;

        $uses = $thing->uses ?? collect();
        if ($uses->isEmpty()) {
            // Пытаемся загрузить, если не загружено
            try {
                $uses = $thing->uses()->with('user', 'place')->get();
            } catch (\Exception $e) {
                $uses = collect();
            }
        }

        $lastUse = $uses->last();
        $lastUser = optional($lastUse)->user;
        $place = optional($lastUse)->place;

        Archive::create([
            'name' => $name,
            'description' => optional($thing->currentDescription)->content,
            'wrnt' => $wrnt,
            'unit_symbol' => $unitSymbol,

            'owner_name' => $ownerName,
            'owner_id' => $ownerId,

            'last_user_name' => optional($lastUser)->name,
            'last_user_id' => optional($lastUser)->id,

            'place_name' => optional($place)->name,

            'restored' => false,
        ]);
    }
}