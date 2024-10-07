<?php

namespace App\Models\Vehicles;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class VehicleCountry extends Model
{
    use HasFactory;
    use \App\Traits\ModelCanExtend;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    /**
     * Retrieve the model for a bound value.
     *
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)
            ->orWhere('name', $value)
            ->firstOrFail();
    }

    public function name(): Attribute
    {
        return new Attribute(
            get: fn($value) => $value === 'Unknown'
                ? 'Generic Database'
                : $value . ' Database',
        );
    }

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
            ['country_id', 'id', 'id'],   // Foreign keys on each intermediate table
            ['id', 'model_id', 'manufacturer_id']  // Local keys on each related model
        )->groupBy('vehicle_manufacturers.id')->select('vehicle_manufacturers.*');
    }

    /**
     * Get all of the years for the VehicleCountry
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function years(): HasManyThrough
    {
        return $this->hasManyThrough(
            VehicleYear::class,  // The final related model
            Vehicle::class,      // The intermediate model
            'country_id',        // Foreign key on the Vehicle table
            'id',                // Foreign key on the VehicleYear table
            'id',                // Local key on the VehicleCountry table
            'year_id'            // Local key on the Vehicle table (that links to VehicleYear)
        )->select('vehicle_years.*');
    }
}