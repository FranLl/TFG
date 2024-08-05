<?php

use Illuminate\Support\Facades\Route;
// Added to use this controller
use App\Http\Controllers\Web\BlockController;


// Homepage route
Route::get('/', function () {
    return view('welcome');
});

// Added by JetStream when I installed installing Livewire
// TODO: esta bien como lo hago?
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    #Route::get('/dashboard', function () {
    #    return view('dashboard');
    #})->name('dashboard');
    Route::get('/dashboard', [BlockController::class, 'index'])->name('dashboard'); # Con el ->name le indico el nombre de la ruta en el código de las views
    Route::get('/block/{blockId}', [BlockController::class, 'show']);
    Route::get('/hornet', function () {
          return view('hornet');
    })->name('hornet');
});
