<?php

namespace App\Traits;

use Valorin\Random\Random;

trait ModelCanExtend
{
    /**
     * Generate a Username for the user.
     *
     * @param  \Illuminate\Support\Stringable|string  $string
     * @return string
     */
    protected static function generateUsername($string, $field = 'username')
    {
        $username = str($string)->slug('_');

        if (static::where($field, $username)->exists()) {
            $username = $username->append('-')->append(Random::number(1111, 9999));
        }

        return $username->toString();
    }
}
