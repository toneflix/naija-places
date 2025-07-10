<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::prefix('v1')->group(function () {
    if (file_exists(base_path('routes/api'))) {
        array_filter(File::files(base_path('routes/api')), function (\Symfony\Component\Finder\SplFileInfo $file) {
            if ($file->getExtension() === 'php') {
                Route::middleware('api')->group($file->getPathName());
            }
        });
    }

    Route::get('/', function (Request $request) {
        \Artisan::call('app:set-config freemium_domains ""');
        dd(Artisan::output());
        return [
            'api' => config('app.name'),
            'version' => '1.0.1'
        ];
    });
});

// Route::get('/artisan/{input}', function (string $input) {
//     $cmd = explode(' ', $input)[0];
//     $params = array_filter(explode(' ', trim(str_ireplace($cmd, '', $input))));

//     Artisan::call($cmd, $params);
//     dd(Artisan::output());
// });

Route::get('/', function () {
    return [
        'api' => config('app.name'),
    ];
});
