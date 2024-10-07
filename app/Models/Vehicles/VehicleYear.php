<?php

namespace App\Models\Vehicles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class VehicleYear extends Model
{
    use HasFactory;
    use \App\Traits\ModelCanExtend;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    /**
     * Get all of the manufacturers for the VehicleCountry
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function manufacturers(): \Staudenmeir\EloquentHasManyDeep\HasManyDeep
    {
        /**
         * TODO: If you end up using a none sqlite database, ->groupBy('vehicle_manufacturers.id')
         * may pose as a problem that may need to be fixed
         */

        return $this->hasManyDeep(
            VehicleManufacturer::class,  // The final related model
            [Vehicle::class, VehicleModel::class],  // The intermediate models (vehicles and vehicle_models)
            ['year_id', 'id', 'id'],   // Foreign keys on each intermediate table
            ['id', 'model_id', 'manufacturer_id']  // Local keys on each related model
        )->groupBy('vehicle_manufacturers.id')->select('vehicle_manufacturers.*');

        // return $this->hasManyDeepFromRelationsWithConstraints(
        //     [$this, 'models'],
        //     [new VehicleModel(), 'manufacturer']
        // )->select('vehicle_manufacturers.*');
    }

    /**
     * Get all of the vehicles for the VehicleYear
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    /**
     * Get all of the models for the VehicleYear
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function models(): HasManyThrough
    {
        return $this->hasManyThrough(
            VehicleModel::class,
            Vehicle::class,                // The intermediate model (Vehicle)
            'year_id',                     // Foreign key on the Vehicle table (links to VehicleYear)
            'id',                          // Foreign key on the VehicleModel table
            'id',                          // Local key on the VehicleYear table
            'model_id'                     // Foreign key on the Vehicle table (links to VehicleModel)
        )->select('vehicle_models.*');
    }
}