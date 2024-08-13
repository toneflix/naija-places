<?php

namespace App\Services;

use App\Enums\HttpStatus;
use App\Helpers\Providers;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Foundation\Exceptions\RegisterErrorViewPaths;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

class ExceptionHandler // extends Handler
{
    protected static $request;

    protected static $message;

    public static function render($request, Throwable $e)
    {
        static::$request = $request;

        if ($request->isXmlHttpRequest() || request()->is('api/*')) {
            $line = method_exists($e, 'getFile') ? ' in ' . $e->getFile() : '';
            $line .= method_exists($e, 'getLine') ? ' on line ' . $e->getLine() : '';
            $msg = method_exists($e, 'getMessage') ? $e->getMessage() . $line : 'An error occured' . $line;
            $plainMessage = method_exists($e, 'getMessage') ? $e->getMessage() : null;

            if ((bool) collect($e?->getTrace())->firstWhere('function', 'abort')) {
                static::$message = $e->getMessage();
            }

            $prefix = $e instanceof ModelNotFoundException ? str($e->getModel())->afterLast('\\')->lower() : '';

            return match (true) {
                $e instanceof NotFoundHttpException ||
                    $e instanceof ModelNotFoundException => static::renderException(
                    str(str($msg)->contains('The route')
                        ? str($msg)->before('.')->append('.')
                        : HttpStatus::message(HttpStatus::NOT_FOUND))->replace('resource', $prefix ?: 'resource'),
                    HttpStatus::NOT_FOUND
                ),
                $e instanceof \Spatie\Permission\Exceptions\UnauthorizedException ||
                    $e instanceof AuthorizationException ||
                    $e instanceof AccessDeniedHttpException ||
                    $e->getCode() === HttpStatus::FORBIDDEN => static::renderException(
                    $plainMessage ? $plainMessage : HttpStatus::message(HttpStatus::FORBIDDEN),
                    HttpStatus::FORBIDDEN
                ),
                $e instanceof AuthenticationException ||
                    $e instanceof UnauthorizedHttpException => static::renderException(
                    $plainMessage !== 'Unauthenticated.' ? $plainMessage :  HttpStatus::message(HttpStatus::UNAUTHORIZED),
                    HttpStatus::UNAUTHORIZED
                ),
                $e instanceof MethodNotAllowedHttpException => static::renderException(
                    HttpStatus::message(HttpStatus::METHOD_NOT_ALLOWED),
                    HttpStatus::METHOD_NOT_ALLOWED
                ),
                $e instanceof ValidationException => static::renderException(
                    $e->getMessage(),
                    HttpStatus::UNPROCESSABLE_ENTITY,
                    ['errors' => $e->errors()]
                ),
                $e instanceof UnprocessableEntityHttpException => static::renderException(
                    HttpStatus::message(HttpStatus::UNPROCESSABLE_ENTITY),
                    HttpStatus::UNPROCESSABLE_ENTITY
                ),
                $e instanceof ThrottleRequestsException => static::renderException(
                    $plainMessage ?: HttpStatus::message(HttpStatus::TOO_MANY_REQUESTS),
                    HttpStatus::TOO_MANY_REQUESTS
                ),
                default => static::renderException($msg, HttpStatus::SERVER_ERROR),
            };
        } elseif (static::isHttpException($e) && $e->getStatusCode() !== 401) {
            static::registerErrorViewPaths();

            return response()->view(
                'errors.generic',
                [
                    'message' => $e->getMessage(),
                    'code' => $e->getStatusCode(),
                ],
                $e->getStatusCode()
            );
        }
    }

    protected static function renderException(string $msg, $code = 404, array $misc = [])
    {
        return Providers::response()->error([
            'message' => static::$message ?? $msg,
            ...array_merge($misc, ['data' => new \stdClass()]),
        ], $code);
    }

    /**
     * Determine if the given exception is an HTTP exception.
     *
     * @return bool
     */
    protected static function isHttpException(Throwable $e)
    {
        return $e instanceof HttpExceptionInterface;
    }

    /**
     * Register the error template hint paths.
     *
     * @return void
     */
    protected static function registerErrorViewPaths()
    {
        (new RegisterErrorViewPaths())();
    }
}