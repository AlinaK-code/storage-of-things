<?php

namespace App\Http\Controllers;

use App\Models\Thing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThingController extends Controller
{
    public function index()
    {
        $things = Thing::where('master', Auth::id())->get();
        return view('things.index', compact('things'));
    }

    public function create()
    {
        return view('things.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'wrnt' => 'nullable|date',
        ]);

        Thing::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'wrnt' => $validated['wrnt'],
            'master' => Auth::id(),
        ]);

        return redirect()->route('things.index')->with('success', 'Вещь создана!');
    }

    public function show(Thing $thing)
    {
        if ($thing->master !== Auth::id()) {
            abort(403);
        }
        return view('things.show', compact('thing'));
    }

    public function edit(Thing $thing)
    {
        if ($thing->master !== Auth::id()) {
            abort(403);
        }
        return view('things.edit', compact('thing'));
    }

    public function update(Request $request, Thing $thing)
    {
        if ($thing->master !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'wrnt' => 'nullable|date',
        ]);

        $thing->update($validated);

        return redirect()->route('things.index')->with('success', 'Вещь обновлена!');
    }

    public function destroy(Thing $thing)
    {
        if ($thing->master !== Auth::id()) {
            abort(403);
        }

        $thing->delete();
        return redirect()->route('things.index')->with('success', 'Вещь удалена!');
    }
}