<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

// Guest auth
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Authenticated area
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Watch & earn
    Route::get('ads', [AdController::class, 'index'])->name('ads.index');
    Route::get('ads/{ad}', [AdController::class, 'show'])->name('ads.show');
    Route::post('ads/{ad}/confirm', [AdController::class, 'confirm'])->name('ads.confirm');

    // Rewards
    Route::get('rewards', [RewardController::class, 'index'])->name('rewards.index');
    Route::post('rewards/check-in', [RewardController::class, 'checkIn'])->name('rewards.checkin');
    Route::post('rewards/spin', [RewardController::class, 'spin'])->name('rewards.spin');

    // Manual crypto deposit
    Route::get('deposit', [DepositController::class, 'index'])->name('deposits.index');
    Route::post('deposit', [DepositController::class, 'store'])->name('deposits.store');

    // Manual crypto withdrawal
    Route::get('withdraw', [WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('withdraw', [WithdrawalController::class, 'store'])->name('withdrawals.store');
});
