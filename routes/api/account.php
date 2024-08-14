<?php

use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('account')->name('account.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::apiResource('api-keys', ApiKeyController::class);
})->scopeBindings();