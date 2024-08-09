<?php

namespace App\Http\Middleware;

use App\Enums\HttpStatus;
use App\Helpers\Providers;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return $request->expectsJson()
                    ? Providers::response()->error([
                        'message' => 'You are already logged in as '.$request->user()->fullname,
                    ], HttpStatus::FORBIDDEN)
                    : redirect('/');
            }
        }

        return $next($request);
    }
}
