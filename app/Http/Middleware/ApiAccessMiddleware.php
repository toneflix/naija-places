<?php

namespace App\Http\Middleware;

use App\Helpers\Providers;
use App\Models\ApiKey;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ApiAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        foreach (Providers::config('freemium_domains', []) as $domain) {
            $ref = str(parse_url($request->header('referer'), PHP_URL_HOST));

            if ($ref->contains($domain)) {
                return $next($request);
            }
        }

        if (!$request->hasHeader('X-Api-key')) {
            throw new AuthenticationException('Unauthorized. You do not have access to this resource.');
        };

        $key = ApiKey::where('key', $request->header('X-Api-key'))->first();

        if (!$key) {
            throw new AuthenticationException('Unauthorized. Invalid API key.');
        }

        if ($key->rate_limit) {
            if (RateLimiter::tooManyAttempts(key: 'api-access:' . $key->id, maxAttempts: $key->rate_limit)) {
                $seconds = RateLimiter::availableIn('api-access:' . $key->id);

                $key->rate_limited = true;
                $key->updateQuietly();
                throw new ThrottleRequestsException('Rate limit exeeded: you may try again in ' . $seconds . ' seconds.');
            }

            if ($key->rate_limited) {
                $key->update(['rate_limited' => false]);
            }

            RateLimiter::hit('api-access:' . $key->id);
        }

        return $response;
    }
}