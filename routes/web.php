<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return str(File::get(public_path('index.html')))
        ->replace(
            '</head>',
            '<meta name="csrf-token" content="' . csrf_token() . '">
            </head>'
        )
        ->toString();
});

Route::fallback(function () {
    return str(File::get(public_path('index.html')))
        ->replace(
            '</head>',
            '<meta name="csrf-token" content="' . csrf_token() . '">
            </head>'
        )
        ->toString();
});
