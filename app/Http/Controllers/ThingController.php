<?php

namespace App\Http\Controllers;

use App\Models\Thing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ThingController extends Controller
{
    use AuthorizesRequests;
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

    public function myThings()
    {
        $things = Thing::where('master', auth()->id())->get();
        return view('things.list', compact('things'))
            ->with('title', 'My things');
    }

    public function repairThings()
    {
        $things = Thing::whereHas('uses.place', function ($query) {
            $query->where('repair', true);
        })->get();
        return view('things.list', compact('things'))
            ->with('title', 'Repair things');
    }

    public function workThings()
    {
        $things = Thing::whereHas('uses.place', function ($query) {
            $query->where('work', true);
        })->get();
        return view('things.list', compact('things'))
            ->with('title', 'Work');
    }

    public function usedThings()
    {
        $things = Thing::where('master', auth()->id())
            ->whereHas('uses', function ($query) {
                $query->where('user_id', '!=', auth()->id());
            })->get();
        return view('things.list', compact('things'))
            ->with('title', 'Used things');
    }

    public function adminThings()
    {
        $this->authorize('admin-access'); // проверка через Gate

        $things = Thing::with('owner')->get();
        return view('things.admin', compact('things'));
    }
}