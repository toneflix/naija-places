<?php

use App\Http\Controllers\Vehicles\VehicleController;
use App\Http\Controllers\Vehicles\VehicleCountryController;
use App\Http\Controllers\Vehicles\VehicleDerivativeController;
use App\Http\Controllers\Vehicles\VehicleManufacturerController;
use App\Http\Controllers\Vehicles\VehicleModelController;
use App\Http\Controllers\Vehicles\VehicleYearController;
use Illuminate\Support\Facades\Route;

Route::middleware([\App\Http\Middleware\ApiAccessMiddleware::class])->prefix('vehicle')->name('vehicle.')->group(function () {
    Route::get('/years', [VehicleYearController::class, 'index'])->name('years.index');
    Route::get('/models', [VehicleModelController::class, 'index'])->name('models.index');
    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/countries', [VehicleCountryController::class, 'index'])->name('countries.index');
    Route::get('/derivatives', [VehicleDerivativeController::class, 'index'])->name('derivatives.index');
    Route::get('/manufacturers', [VehicleManufacturerController::class, 'index'])->name('manufacturers.index');

    // Country Index
    Route::get('/countries/{country}/years', [VehicleYearController::class, 'countryIndex'])
        ->name('countries.years.index');

    Route::get('/countries/{country}/manufacturers', [VehicleManufacturerController::class, 'countryIndex'])
        ->name('countries.manufacturers.index');

    // Year Index
    Route::get('/years/{year}/manufacturers', [VehicleManufacturerController::class, 'yearIndex'])
        ->name('years.manufacturers.index');

    // Year/Country Index
    Route::get('/years/{year}/countries/{country}/manufacturers', [VehicleManufacturerController::class, 'yearCountryIndex'])
        ->name('countries.years.manufacturers.index');

    // Manufacturer Index
    Route::get('/manufacturers/{manufacturer}/models', [VehicleModelController::class, 'manufacturerIndex'])
        ->name('manufacturers.models.index');

    Route::get('/manufacturers/{manufacturer}/vehicles', [VehicleController::class, 'manufacturerIndex'])
        ->name('manufacturers.vehicles.index');

    // Model Index
    Route::get('/models/{model}/derivatives', [VehicleDerivativeController::class, 'modelIndex'])
        ->name('models.derivatives.index');
})->scopeBindings();
