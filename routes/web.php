<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
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

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth:admin_users', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});