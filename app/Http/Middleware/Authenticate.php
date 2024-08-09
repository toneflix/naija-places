<?php

namespace App\Http\Middleware;

use App\Enums\HttpStatus;
use App\Helpers\Providers;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson()
        ? Providers::response()->error([
            'message' => 'please login to continue.',
        ], HttpStatus::FORBIDDEN)
        : route('login');
    }
}
