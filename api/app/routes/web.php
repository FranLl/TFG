<?php

use Illuminate\Support\Facades\Route;
// Added to use this controller
use App\Http\Controllers\Web\BlockController;


// Welcome page route
Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [BlockController::class, 'index'])->name('dashboard'); 
    Route::get('/block/{blockId}', [BlockController::class, 'show']);
    Route::get('/hornet', function () {
          return view('hornet');
    })->name('hornet');
});
