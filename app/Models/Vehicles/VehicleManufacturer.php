<?php

namespace App\Models\Vehicles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class VehicleManufacturer extends Model
{
    use HasFactory;

    /**
     * Get all of the vehicles for the VehicleManufacturer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function vehicles(): HasManyThrough
    {
        return $this->hasManyThrough(
            Vehicle::class,
            VehicleModel::class,
            'manufacturer_id',
            'model_id',
        )->select('vehicles.*')->groupBy('vehicle_models.id');
    }

    /**
     * Get all of the models for the VehicleManufacturer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function models(): HasMany
    {
        return $this->hasMany(
            VehicleModel::class,
            'manufacturer_id'
        );
    }
}
