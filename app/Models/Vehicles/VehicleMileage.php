<?php

namespace App\Models\Vehicles;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMileage extends Model
{
    use HasFactory;
    use \App\Traits\ModelCanExtend;

    /**
     * The attributes to be appended
     *
     * @var array
     */
    protected $appends = [
        'miles_per_gallon',
        'mixed_fuel_consumption_per_100km_l',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'city_fuel_per_100km_l' => 'integer',
            'highway_fuel_per_100km_l' => 'integer',
            'mixed_fuel_consumption_per_100km_l' => 'integer',
        ];
    }

    public function milesPerGallon(): Attribute
    {
        return new Attribute(
            get: fn() => round((235.214583 / ($this->mixed_fuel_consumption_per_100km_l ?: 1)), 2),
        );
    }

    public function mixedFuelConsumptionPer100KmL(): Attribute
    {
        return new Attribute(
            get: fn($value) => intval($value) ?: ($this->city_fuel_per_100km_l * 0.55) + ($this->highway_fuel_per_100km_l * 0.45),
        );
    }
}