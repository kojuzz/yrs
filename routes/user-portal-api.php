<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserPortal\AuthController;
use App\Http\Controllers\Api\UserPortal\BuyTicketController;
use App\Http\Controllers\Api\UserPortal\ProfileController;
use App\Http\Controllers\Api\UserPortal\TicketController;
use App\Http\Controllers\Api\UserPortal\TicketPricingController;
use App\Http\Controllers\Api\UserPortal\TopUpController;
use App\Http\Controllers\Api\UserPortal\TopUpHistoryController;
use App\Http\Controllers\Api\UserPortal\WalletTransactionController;

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


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('two-step-verification', [AuthController::class, 'twoStepVerification']);
Route::post('resend-otp', [AuthController::class, 'resendOTP']);

Route::middleware(['auth:users_api', 'verified'])->group(function () {
    Route::get('profile', [ProfileController::class, 'profile']);
    Route::post('change-password', [ProfileController::class, 'changePassword']);
    Route::post('logout', [AuthController::class, 'logout']);

    // Ticket
    Route::get('ticket', [TicketController::class, 'index']);
    Route::get('ticket/{ticket_number}', [TicketController::class, 'show']);

    // Ticket Pricing
    Route::get('ticket-pricing', [TicketPricingController::class, 'index']);

    // Buy Ticket
    Route::post('buy-ticket', [BuyTicketController::class, 'store']);

    // Tupup
        // History
        Route::get('top-up-history', [TopUpHistoryController::class, 'index']);
        Route::get('top-up-history/{trx_id}', [TopUpHistoryController::class, 'show']);

        // Topup
        Route::post('top-up', [TopUpController::class, 'store']);

    // Wallet Transaction
    Route::get('wallet-transaction', [WalletTransactionController::class, 'index']);
    Route::get('wallet-transaction/{trx_id}', [WalletTransactionController::class, 'show']);
});
