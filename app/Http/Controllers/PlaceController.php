<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;
use App\Events\PlaceCreated;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class PlaceController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $userId = auth()->id();
        
        $places = Cache::remember("places_user_{$userId}", 600, function () use ($userId) {
            return Place::where('master', $userId)->get();
        });

        return view('places.index', compact('places'));
    }

    public function create()
    {
        return view('places.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'repair' => 'boolean',
            'work' => 'boolean',
        ]);

        $placeData = $request->all();
        $placeData['master'] = auth()->id();

        $place = Place::create($placeData);

        // Вещание события
        broadcast(new PlaceCreated($place));

        // Очистка кэша
        Cache::forget("places_user_" . auth()->id());
        // Если есть админка — очисти и её кэш

        return redirect()->route('places.index')->with('success', 'Место создано!');
    }

    public function show(Place $place)
    {
        return view('places.show', compact('place'));
    }

    public function edit(Place $place)
    {
        $this->authorize('update', $place);
        return view('places.edit', compact('place'));
    }

    public function update(Request $request, Place $place)
    {
        $this->authorize('update', $place);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'repair' => 'boolean',
            'work' => 'boolean',
        ]);

        $place->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'repair' => $request->has('repair') ? true : false,
            'work' => $request->has('work') ? true : false,
        ]);

        return redirect()->route('places.index')->with('success', 'Место обновлено!');
    }

    public function destroy(Place $place)
    {
        $this->authorize('update', $place);
        $place->delete();
        return redirect()->route('places.index')->with('success', 'Место удалено!');
    }
}