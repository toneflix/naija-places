<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    if (file_exists(base_path('routes/api'))) {
        array_filter(File::files(base_path('routes/api')), function (\Symfony\Component\Finder\SplFileInfo $file) {
            if ($file->getExtension() === 'php') {
                Route::middleware('api')->group($file->getPathName());
            }
        });
    }

    Route::get('/', function (Request $request) {
        return [
            'api' => config('app.name'),
            'version' => '1.0.1'
        ];
    });
});

Route::get('/', function () {
    return [
        'api' => config('app.name'),
    ];
});
