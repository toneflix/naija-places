<?php

namespace App\Providers;

use App\Models\City;
use App\Models\Lga;
use App\Models\State;
use App\Models\Unit;
use App\Models\Ward;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Request $request): void
    {
        \App\Helpers\Providers::buildResponseMacros();

        // Force https
        if (config('app.env') === 'production' || config('app.force_https')) {
            URL::forceScheme('https');
        }

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        \App\Helpers\Providers::rateLimitCodeRequests();
    }
}