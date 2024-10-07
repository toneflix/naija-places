<?php

namespace App\Models\Vehicles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class VehicleManufacturer extends Model
{
    use HasFactory;
    use \App\Traits\ModelCanExtend;

    /**
     * Get all of the vehicles for the VehicleManufacturer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function vehicles(): HasManyThrough
    {
        /**
         * TODO: If you end up using a none sqlite database, ->groupBy('vehicle_models.id')
         * may pose as a problem that may need to be fixed
         */

        return $this->hasManyThrough(
            Vehicle::class,
            VehicleModel::class,
            'manufacturer_id',
            'model_id',
        )
            ->select(['vehicles.*', 'vehicle_models.id'])
            ->groupBy('vehicle_models.id');
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