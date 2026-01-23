<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archive;
use App\Models\Thing;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;

class ArchiveController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $archives = Archive::latest()->get();
        } else {
            $archives = Archive::where('owner_id', auth()->id())->latest()->get();
        }
        return view('archive.index', compact('archives'));
    }

    public function restore(Archive $archive): RedirectResponse
    {
        // Админ может восстановить любую запись
        // Владелец — только свою
        if (!auth()->user()->isAdmin() && $archive->owner_id !== auth()->id()) {
            abort(403, 'Недостаточно прав для восстановления этой вещи.');
        }

        $unit = Unit::where('symbol', $archive->unit_symbol)->first();

        $thing = Thing::create([
            'name' => $archive->name,
            'wrnt' => $archive->wrnt,
            'unit_id' => $unit?->id,
            'master' => auth()->id(), // новый хозяин — тот, кто восстановил
        ]);

        if ($archive->description) {
            \App\Models\Description::create([
                'thing_id' => $thing->id,
                'content' => $archive->description,
                'is_current' => true,
            ]);
        }

        $archive->update([
            'restored' => true,
            'restored_by_id' => auth()->id(),
            'restored_by_name' => auth()->user()->name,
            'restored_at' => now(),
        ]);

        return redirect()->route('archive.index')->with('success', 'Вещь успешно восстановлена!');
    }
}



