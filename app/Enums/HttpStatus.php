<?php

namespace App\Enums;

/**
 * HTTP Status codes.
 */
enum HttpStatus: int
{
    case OK = 200;                   // OK
    case CREATED = 201;              // Created
    case ACCEPTED = 202;             // Created
    case NO_CONTENT = 204;           // No Content
    case BAD_REQUEST = 400;          // Bad Request
    case UNAUTHORIZED = 401;         // Unauthenticated
    case FORBIDDEN = 403;            // Access Denied
    case NOT_FOUND = 404;            // Not Found
    case METHOD_NOT_ALLOWED = 405;   // Method Not Allowed
    case CONFLICT = 409;             // Conflict
    case UNPROCESSABLE_ENTITY = 422; // Unprocessable Entity
    case TOO_MANY_REQUESTS = 429;    // Too Many Requests
    case SERVER_ERROR = 500;         // Internal Server Error

    /**
     * Get the message for the provided code
     */
    public static function message(int|HttpStatus $code): string
    {
        $code = is_int($code) ? HttpStatus::from($code) : $code;

        return match ($code) {
            HttpStatus::OK => 'Data Fetched.',
            HttpStatus::CREATED => 'Created.',
            HttpStatus::ACCEPTED => 'Accepted.',
            HttpStatus::CONFLICT => 'Conflict.',
            HttpStatus::FORBIDDEN => 'We are sorry, but you do not have permission to perform this action.',
            HttpStatus::NOT_FOUND => 'The requested resource was not found.',
            HttpStatus::NO_CONTENT => 'No Content.',
            HttpStatus::BAD_REQUEST => 'Something went wrong.',
            HttpStatus::UNAUTHORIZED => 'Unauthenticated: Please login to continue.',
            HttpStatus::SERVER_ERROR => 'Whoops! Something went wrong on our end. Please try again later.',
            HttpStatus::TOO_MANY_REQUESTS => 'You have made too many requests. Please try again later.',
            HttpStatus::METHOD_NOT_ALLOWED => 'The requested method is not allowed.',
            HttpStatus::UNPROCESSABLE_ENTITY => 'The given data was invalid.',
            default => 'Not found.',
        };
    }
}
