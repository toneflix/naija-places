<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait PlaceFilter
{
    protected function scopeOnlyAllowed(Builder $builder, string $allowed, string $key = 'iso2'): void
    {
        $allowed = str($allowed)->remove(' ')->lower()->explode(',');

        $builder->whereIn(DB::raw("LOWER({$key})"), $allowed);
    }

    protected function scopeNotBanned(Builder $builder, string $banned, string $key = 'iso2'): void
    {
        $banned = str($banned)->remove(' ')->lower()->explode(',');

        $builder->whereNotIn(DB::raw("LOWER({$key})"), $banned);
    }
}
