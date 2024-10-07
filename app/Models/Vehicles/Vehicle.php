<?php

namespace App\Models\Vehicles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vehicle extends Model
{
    use HasFactory;

    /**
     * Get the model that owns the Vehicle
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function model(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }

    /**
     * Get the engine that owns the Vehicle
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function engine(): HasOne
    {
        return $this->hasOne(VehicleEngine::class);
    }

    /**
     * Get the mileage that owns the Vehicle
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mileage(): HasOne
    {
        return $this->hasOne(VehicleMileage::class);
    }

    /**
     * Get the derivative that owns the Vehicle
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function derivative(): BelongsTo
    {
        return $this->belongsTo(VehicleDerivative::class);
    }

    /**
     * Get the year that owns the Vehicle
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function year(): BelongsTo
    {
        return $this->belongsTo(VehicleYear::class);
    }

    /**
     * Get the country that owns the Vehicle
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(VehicleCountry::class);
    }
}