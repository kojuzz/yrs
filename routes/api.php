<?php

use App\Http\Controllers\Api\RouteController;
use App\Http\Controllers\Api\StationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Station
Route::get('station', [StationController::class, 'index']);
Route::get('station/{slug}', [StationController::class, 'show']);
Route::get('station-by-region', [StationController::class, 'byRegion']);

// Route
Route::get('route', [RouteController::class, 'index']);
Route::get('route/{slug}', [RouteController::class, 'show']);
