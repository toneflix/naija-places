<?php

use App\Http\Controllers\ApiKeyController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('account')->name('account.')->group(function () {
    Route::apiResource('api-keys', ApiKeyController::class);
})->scopeBindings();