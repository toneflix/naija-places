<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property Collection<int, Lga> $lgas
 * @property Collection<int, Ward> $wards
 * @property Collection<int, City> $cities
 * @property Collection<int, Unit> $units
 */
class State extends Model
{
    use HasFactory;

    /**
     * Retrieve the model for a bound value.
     *
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)
            ->orWhereRaw('LOWER(code) = ?', [mb_strtolower($value)])
            ->orWhere('slug', $value)
            ->orWhere('code', $value)
            ->orWhere('name', $value)
            ->firstOrFail();
    }

    /**
     * Get all of the lgas for the State
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lgas(): HasMany
    {
        return $this->hasMany(Lga::class);
    }

    /**
     * Get all of the wards for the State
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wards(): HasMany
    {
        return $this->hasMany(Ward::class);
    }

    /**
     * Get all of the units for the State
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    /**
     * Get all of the cities for the State
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function logs(): MorphMany
    {
        return $this->morphMany(Log::class, 'model');
    }
}
