<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\LgaController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WardController;
use Illuminate\Support\Facades\Route;

Route::prefix('states')->name('states.')->group(function () {
    Route::get('/', [StateController::class, 'index'])->name('index');
    Route::get('/{state}/lgas', [LgaController::class, 'index'])->name('lgas.index');
    Route::get('/{state}/lgas/{lga}/wards', [WardController::class, 'index'])->name('wards.index');
    Route::get('/{state}/lgas/{lga}/wards/{ward}/units', [UnitController::class, 'index'])->name('wards.index');
    Route::get('/{state}/cities', [CityController::class, 'index'])->name('cities.index');
})->scopeBindings();
