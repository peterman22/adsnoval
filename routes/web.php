<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('withdraw-feed', [SiteController::class, 'withdrawFeed'])->name('withdraw.feed');

// Guest auth
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});
// OTP verification (session-gated, not behind auth)
Route::get('verify', [AuthController::class, 'showVerify'])->name('verify.show');
Route::post('verify', [AuthController::class, 'verifyOtp'])->name('verify.submit');
Route::post('verify/resend', [AuthController::class, 'resendOtp'])->name('verify.resend');

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Authenticated user area
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('ads', [AdController::class, 'index'])->name('ads.index');
    Route::get('ads/{ad}', [AdController::class, 'show'])->name('ads.show');
    Route::post('ads/{ad}/confirm', [AdController::class, 'confirm'])->name('ads.confirm');

    Route::get('rewards', [RewardController::class, 'index'])->name('rewards.index');
    Route::post('rewards/check-in', [RewardController::class, 'checkIn'])->name('rewards.checkin');
    Route::post('rewards/spin', [RewardController::class, 'spin'])->name('rewards.spin');

    Route::get('deposit', [DepositController::class, 'index'])->name('deposits.index');
    Route::post('deposit', [DepositController::class, 'store'])->name('deposits.store');

    Route::get('withdraw', [WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('withdraw', [WithdrawalController::class, 'store'])->name('withdrawals.store');

    Route::get('plans', [PlanController::class, 'index'])->name('plans.index');
    Route::post('plans/{plan}/buy', [PlanController::class, 'buy'])->name('plans.buy');

    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('referrals', [ReferralController::class, 'index'])->name('referrals.index');
});

/* ---------------- Admin panel ---------------- */
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [Admin\AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [Admin\AdminAuthController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [Admin\AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::get('deposits', [Admin\DepositController::class, 'index'])->name('deposits');
        Route::post('deposits/{deposit}/approve', [Admin\DepositController::class, 'approve'])->name('deposits.approve');
        Route::post('deposits/{deposit}/reject', [Admin\DepositController::class, 'reject'])->name('deposits.reject');

        Route::get('withdrawals', [Admin\WithdrawalController::class, 'index'])->name('withdrawals');
        Route::post('withdrawals/{withdrawal}/paid', [Admin\WithdrawalController::class, 'markPaid'])->name('withdrawals.paid');
        Route::post('withdrawals/{withdrawal}/reject', [Admin\WithdrawalController::class, 'reject'])->name('withdrawals.reject');

        Route::get('plans', [Admin\PlanController::class, 'index'])->name('plans');
        Route::post('plans', [Admin\PlanController::class, 'store'])->name('plans.store');
        Route::post('plans/{plan}', [Admin\PlanController::class, 'update'])->name('plans.update');
        Route::delete('plans/{plan}', [Admin\PlanController::class, 'destroy'])->name('plans.destroy');

        Route::get('ads', [Admin\AdController::class, 'index'])->name('ads');
        Route::post('ads', [Admin\AdController::class, 'store'])->name('ads.store');
        Route::post('ads/{ad}', [Admin\AdController::class, 'update'])->name('ads.update');
        Route::delete('ads/{ad}', [Admin\AdController::class, 'destroy'])->name('ads.destroy');

        Route::get('crypto', [Admin\CryptoMethodController::class, 'index'])->name('crypto');
        Route::post('crypto', [Admin\CryptoMethodController::class, 'store'])->name('crypto.store');
        Route::post('crypto/{method}', [Admin\CryptoMethodController::class, 'update'])->name('crypto.update');
        Route::delete('crypto/{method}', [Admin\CryptoMethodController::class, 'destroy'])->name('crypto.destroy');

        Route::get('users', [Admin\UserController::class, 'index'])->name('users');
        Route::post('users/{user}/ban', [Admin\UserController::class, 'toggleBan'])->name('users.ban');
        Route::post('users/{user}/balance', [Admin\UserController::class, 'adjustBalance'])->name('users.balance');

        Route::get('settings', [Admin\SettingController::class, 'index'])->name('settings');
        Route::post('settings', [Admin\SettingController::class, 'save'])->name('settings.save');
        Route::get('templates', [Admin\SettingController::class, 'templates'])->name('templates');
        Route::post('templates/{template}', [Admin\SettingController::class, 'saveTemplate'])->name('templates.save');
    });
});
