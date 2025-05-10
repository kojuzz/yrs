<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserPortal\AuthController;

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

Route::prefix('user_port')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
});