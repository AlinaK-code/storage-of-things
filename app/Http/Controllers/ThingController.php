<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Place;
use App\Models\UseRecord;
use App\Models\Description;
use App\Models\Thing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache; // для кеширования
use App\Events\ThingCreated;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ThingController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        // Решила поменять логику: тут теперь отображаются все вещи, но только в режиме просмотра
        $things = Thing::with('owner', 'unit', 'uses.place')->get();
        return view('things.index', compact('things'));
    }
    // public function index()
    // {
    //     $userId = auth()->id();
    //     // кеширую с помощью встроенного кэша Laravel Cache::remember() на 10 минут (600 секунд)
    //     $things = Cache::remember("things_user_{$userId}", 600, function () use ($userId) {
    //         return Thing::where('master', $userId)->with('unit')->get();
    //     });
    //     return view('things.index', compact('things'));
    // }

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
            'unit_id' => 'nullable|exists:units,id',
        ]);

        $thing = Thing::create([
            'name' => $validated['name'],
            'wrnt' => $validated['wrnt'],
            'unit_id' => $validated['unit_id'],
            'master' => Auth::id(),
        ]);

        // Создаём первое описание
        if (!empty($validated['description'])) {
            Description::create([
                'thing_id' => $thing->id,
                'content' => $validated['description'],
                'is_current' => true,
            ]);
        }

        broadcast(new ThingCreated($thing));

        return redirect()->route('things.index')->with('success', 'Вещь создана!');
    }

    public function show(Thing $thing)
    {
        if ($thing->master !== Auth::id()) {
            abort(403);
        }
        
        $descriptions = $thing->descriptions()->orderBy('created_at', 'desc')->get();
        return view('things.show', compact('thing', 'descriptions'));
    }

    public function edit(Thing $thing)
    {
        if ($thing->master !== Auth::id()) {
            abort(403);
        }
        $this->authorize('update', $thing);
        return view('things.edit', compact('thing'));
    }

    public function update(Request $request, Thing $thing)
    {
        if ($thing->master !== Auth::id()) {
            abort(403);
        }

        $this->authorize('update', $thing);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'wrnt' => 'nullable|date',
            'unit_id' => 'nullable|exists:units,id',
        ]);

        $thing->update($validated);
        // после обновлония, очищаю кэш
        Cache::forget("things_user_" . auth()->id());
        Cache::forget('things_admin');

        return redirect()->route('things.index')->with('success', 'Вещь обновлена!');
    }

   public function destroy(Thing $thing)
    {
        $this->authorize('delete', $thing);

        // Архив до дел
        $lastUse = $thing->uses->last();
        \App\Models\Archive::create([
            'name' => $thing->name,
            'description' => $thing->currentDescription?->content,
            'wrnt' => $thing->wrnt,
            'unit_symbol' => $thing->unit?->symbol,
            'owner_name' => $thing->owner?->name,
            'owner_id' => $thing->master,
            'last_user_name' => optional($lastUse?->user)->name,
            'last_user_id' => optional($lastUse?->user)->id,
            'place_name' => optional($lastUse?->place)->name,
            'restored' => false,
        ]);

        $thing->delete();

        return redirect()->back()->with('success', 'Вещь удалена и перемещена в архив.');
    }

    public function myThings()
    {
        $things = Thing::where('master', auth()->id())->with('unit')->get();
        return view('things.my', compact('things')); // ← теперь my.blade.php
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

    // права админа
    public function adminThings()
    {
        $this->authorize('admin-access'); // проверка через Gate

        $things = Cache::remember('things_all_admin', 600, function () {
            return Thing::with('owner', 'unit')->get();
        });
        return view('things.admin', compact('things'));
    }

    // передача своих вещей в другие руки
    public function showAssignForm(Thing $thing)
    {
        $this->authorize('update', $thing); // только хозяин или админ может передать вещь

        $users = User::all();      // все пользователи
        $places = Place::all();    // все места

        // ф-ия compact создает массив из этих элементов
        return view('things.assign', compact('thing', 'users', 'places'));
    }

    // сохранение
    public function assign(Request $request, Thing $thing)
    {
        $this->authorize('update', $thing);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'place_id' => 'required|exists:places,id',
            'amount' => 'required|integer|min=1',
        ]);

        UseRecord::create([
            'thing_id' => $thing->id,
            'user_id' => $request->user_id,
            'place_id' => $request->place_id,
            'amount' => $request->amount,
        ]);

        return redirect()->route('things.show', $thing)->with('success', 'Вещь передана!');
    }

    // показывает вещи всех пользователей 
    public function allThings()
    {
        $things = Thing::with('owner', 'unit')->get();
        return view('things.all', compact('things'));
    }

    // новый метод добавления описания 
    public function addDescription(Request $request, Thing $thing)
    {
        $this->authorize('update', $thing);

        $request->validate([
            'content' => 'required|string',
        ]);

        // Снимаем актуальность со старого
        $thing->descriptions()->where('is_current', true)->update(['is_current' => false]);

        // Создаём новое
        Description::create([
            'thing_id' => $thing->id,
            'content' => $request->content,
            'is_current' => true,
        ]);

        return back()->with('success', 'Описание обновлено!');
    }

    public function uses()
    {
        return $this->hasMany(\App\Models\UseRecord::class);
    }
}