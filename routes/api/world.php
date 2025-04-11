<?php

use App\Http\Controllers\World\CityController;
use App\Http\Controllers\World\CountryController;
use App\Http\Controllers\World\RegionController;
use App\Http\Controllers\World\StateController;
use App\Http\Controllers\World\SubRegionController;
use Illuminate\Support\Facades\Route;

Route::scopeBindings()
    ->middleware([\App\Http\Middleware\ApiAccessMiddleware::class])
    ->prefix('countries')
    ->name('countries.')
    ->group(function () {
        // Countries
        Route::get('/', [CountryController::class, 'index'])->name('index');

        Route::get('/{country}', [CountryController::class, 'show'])->name('show');
        // Countries End =============

        // States
        Route::get('/{country}/states', [StateController::class, 'index'])
            ->name('states.index');

        Route::get('/{country}/states/{state}', [StateController::class, 'show'])
            ->name('states.show');
        // States End =============

        // Cities
        Route::get('/{country}/states/{state}/cities', [CityController::class, 'index'])
            ->name('cities.index');

        Route::get('/{country}/states/{state}/cities/{city}', [CityController::class, 'show'])
            ->name('cities.show');
        // Cities End =============
    });

Route::scopeBindings()
    ->middleware([\App\Http\Middleware\ApiAccessMiddleware::class])
    ->prefix('regions')
    ->name('regions.')
    ->group(function () {
        // Regions
        Route::get('/', [RegionController::class, 'index'])->name('index');
        Route::get('/{region}', [RegionController::class, 'index'])->name('show');
        // Regions End =============

        // Sub Regions
        Route::get('/{region}/subregions', [SubRegionController::class, 'index'])
            ->name('subregions.index');
        // Sub Regions End =============

        Route::get('/{region}/subregions/{subregion}/countries', [CountryController::class, 'index'])
            ->name('subregions.countries.index');

        // Countries
        Route::get('/{region}/countries', [CountryController::class, 'index'])
            ->name('index');
    });

Route::scopeBindings()
    ->middleware([\App\Http\Middleware\ApiAccessMiddleware::class])
    ->prefix('subregions')
    ->name('subregions.')
    ->group(function () {
        Route::get('/', [SubRegionController::class, 'index'])->name('index');
        Route::get('/{subregion}', [SubRegionController::class, 'show'])->name('show');

        // Countries
        Route::get('/{subregion}/countries', [CountryController::class, 'index'])
            ->name('countries.index');
    });
