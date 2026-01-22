<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThingController;
use App\Http\Controllers\PlaceController;

// Route::middleware('auth:sanctum')->group(function () {
//     // вещи (перенесла из web)
//     Route::apiResource('things', ThingController::class);
//     Route::post('things/{thing}/assign', [ThingController::class, 'assign']);
//     Route::get('things/my', [ThingController::class, 'myThings']);
//     Route::get('things/repair', [ThingController::class, 'repairThings']);
//     Route::get('things/work', [ThingController::class, 'workThings']);
//     Route::get('things/used', [ThingController::class, 'usedThings']);
//     Route::get('things/all', [ThingController::class, 'allThings']);

//     // места
//     Route::apiResource('places', PlaceController::class);
// });