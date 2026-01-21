<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThingController;
use App\Http\Controllers\PlaceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// пользователи могут работать с вещами тольок если они авторизованы
Route::middleware('auth')->group(function () {
    // все что связано с профилем
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // доп маршруты для списков вещей
    Route::get('/things/my', [ThingController::class, 'myThings'])->name('things.my');
    Route::get('/things/repair', [ThingController::class, 'repairThings'])->name('things.repair');
    Route::get('/things/work', [ThingController::class, 'workThings'])->name('things.work');
    Route::get('/things/used', [ThingController::class, 'usedThings'])->name('things.used');

    // crud
    Route::resource('things', ThingController::class);
    Route::resource('places', PlaceController::class);

    // для админки
    Route::get('/admin/things', [ThingController::class, 'adminThings'])->name('admin.things');
});

require __DIR__.'/auth.php';
