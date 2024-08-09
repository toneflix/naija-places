<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailPhoneController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->prefix('auth')->group(function () {
    Route::post('register', [RegisteredUserController::class, 'store'])
        ->name('register');

    Route::get('register/preflight/{token}', [RegisteredUserController::class, 'preflight'])
        ->name('register.preflight');

    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->name('login');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware(['throttle:code-requests'])
        ->name('password.email');

    Route::post('reset-password/check-code', [NewPasswordController::class, 'check'])
        ->name('password.code.check');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
});

Route::middleware('auth:sanctum')->prefix('verify')->group(function () {
    Route::post('with-code/{type?}', [VerifyEmailPhoneController::class, 'store'])
        ->middleware(['throttle:code-requests'])
        ->name('verification.store');

    Route::put('with-code/{type?}', [VerifyEmailPhoneController::class, 'update'])
        ->middleware(['throttle:6,1'])
        ->name('verification.update');

    Route::get('with-code/{type?}', [VerifyEmailPhoneController::class, 'show'])
        ->name('verification.show');
});

Route::middleware('auth:sanctum')->prefix('account')->group(function () {
    Route::get('devices', [AuthenticatedSessionController::class, 'getTokens'])
        ->name('authenticated.devices');

    Route::post('devices/logout', [AuthenticatedSessionController::class, 'destroyTokens'])
        ->name('logout');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// Route::post('broadcasting/auth', [AuthenticatedSessionController::class, 'broadcastingAuth'])
//     ->middleware('auth:sanctum')
//     ->name('broadcasting.auth');
