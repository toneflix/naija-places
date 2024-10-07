<?php

namespace App\Http\Middleware;

use App\Helpers\Providers;
use App\Models\ApiKey;
use App\Models\Log;
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

        /**
         * Check if the request originates from any of the fremium domains
         */
        foreach (Providers::config('freemium_domains', []) as $domain) {
            $ref = str(parse_url($request->header('referer'), PHP_URL_HOST));

            if ($ref->contains($domain)) {
                return $next($request);
            }
        }

        // Get the current url from the request
        $url = str($request->url());

        /**
         * Check if the request originates from the same domain as the API
         */
        if ($url->contains(parse_url($request->header('origin'), PHP_URL_HOST))) {
            return $next($request);
        }

        /**
         * Authenticate the api request
         */
        if (!$request->hasHeader('X-Api-Key')) {
            throw new AuthenticationException('Unauthorized. You do not have access to this resource.');
        };

        // Get the ApiKey model
        $key = ApiKey::where('key', $request->header('X-Api-Key'))->first();

        // Fail the request if the ApiKey model does not exist
        if (!$key) {
            throw new AuthenticationException('Unauthorized. Invalid API key.');
        }

        /**
         * Add rate limiting to the request based on the ApiKey model
         */
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

        // Set the log data
        $log = [
            'endpoint' => parse_url($request->url(), PHP_URL_PATH),
            'ip_address' => $request->ip(),
            'api_key_id' => $key->id,
        ];

        // Save the log request to the Log model
        if ($request->route()->parameters) {
            collect($request->route()->parameters)->last()->logs()->create($log);
        } else {
            Log::create($log);
        }

        return $response;
    }
}
