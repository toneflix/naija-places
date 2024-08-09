<?php

namespace App\Services\Payment;

use Yabacon\Paystack\Contracts\RouteInterface;

class PaystackDeauth implements RouteInterface
{
    public static function root()
    {
        return '/customer';
    }

    public static function deactivateAuthorization()
    {
        return [
            RouteInterface::METHOD_KEY => RouteInterface::POST_METHOD,
            RouteInterface::ENDPOINT_KEY => PaystackDeauth::root() . '/deactivate_authorization',
            RouteInterface::PARAMS_KEY => [
                'authorization_code',
            ],
        ];
    }
}
