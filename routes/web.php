<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\Select2AjaxController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\TicketInspectorController;
use App\Http\Controllers\TicketPricingController;
use App\Http\Controllers\TopUpHistoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WalletTransactionController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/test-mail', function () {
    Mail::raw('This is a test email from Laravel using Gmail SMTP.', function ($message) {
        $message->to('studionine5.mm@gmail.com')
                ->subject('Test Email');
    });
    return 'Mail sent!';
});

require __DIR__.'/auth.php';

Route::middleware('auth:admin_users')->group(function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('change-password', [PasswordController::class, 'edit'])->name('change-password.edit');
    Route::put('change-password', [PasswordController::class, 'update'])->name('change-password.update');
});

Route::middleware(['auth:admin_users', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('admin-user', AdminUserController::class);
    Route::get('admin-user-datatable', [AdminUserController::class, 'datatable'])->name('admin-user-datatable');

    Route::resource('user', UserController::class);
    Route::get('user-datatable', [UserController::class, 'datatable'])->name('user-datatable');

    Route::resource('wallet', WalletController::class)->only('index');
    Route::get('wallet-datatable', [WalletController::class, 'datatable'])->name('wallet-datatable');
    Route::get('wallet-add-amount', [WalletController::class, 'addAmount'])->name('wallet-add-amount');
    Route::post('wallet-add-amount', [WalletController::class, 'addAmountStore'])->name('wallet-add-amount.store');
    Route::get('wallet-reduce-amount', [WalletController::class, 'reduceAmount'])->name('wallet-reduce-amount');
    Route::post('wallet-reduce-amount', [WalletController::class, 'reduceAmountStore'])->name('wallet-reduce-amount.store');

    Route::resource('wallet-transaction', WalletTransactionController::class)->only('index', 'show');
    Route::get('wallet-transaction-datatable', [WalletTransactionController::class, 'datatable'])->name('wallet-transaction-datatable');

    Route::resource('top-up-history', TopUpHistoryController::class)->only('index', 'show');
    Route::get('top-up-history-datatable', [TopUpHistoryController::class, 'datatable'])->name('top-up-history-datatable');
    Route::post('top-up-history-approve/{id}', [TopUpHistoryController::class, 'approve'])->name('top-up-history-approve');
    Route::post('top-up-history-reject/{id}', [TopUpHistoryController::class, 'reject'])->name('top-up-history-reject');

    Route::resource('station', StationController::class);
    Route::get('station-datatable', [StationController::class, 'datatable'])->name('station-datatable');

    Route::resource('ticket-pricing', TicketPricingController::class);
    Route::get('ticket-pricing-datatable', [TicketPricingController::class, 'datatable'])->name('ticket-pricing-datatable');

    Route::resource('route', RouteController::class);
    Route::get('route-datatable', [RouteController::class, 'datatable'])->name('route-datatable');

    Route::resource('ticket-inspector', TicketInspectorController::class);
    Route::get('ticket-inspector-datatable', [TicketInspectorController::class, 'datatable'])->name('ticket-inspector-datatable');

    Route::prefix('select2-ajax')->name('select2-ajax.')->group(function () {
        Route::get('wallet', [Select2AjaxController::class, 'wallet'])->name('wallet');
        Route::get('station', [Select2AjaxController::class, 'station'])->name('station');
    });
});