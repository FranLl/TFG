<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
# Added to use this controller
use App\Http\Controllers\Api\TTNDataController;

// Route to block creation
// https://stackoverflow.com/questions/54721576/laravel-route-apiresource-difference-between-apiresource-and-resource-in-route
// https://stackoverflow.com/questions/63861009/how-to-add-except-rule-in-routeresources
Route::apiResource('ttndata', TTNDataController::class)->only([
    'store'
]);
