<?php

namespace App\Models\Vehicles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class VehicleModel extends Model
{
    use HasFactory;

    /**
     * Get the manufacturer that owns the VehicleModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(VehicleManufacturer::class);
    }

    /**
     * Get all of the vehicles for the VehicleManufacturer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function derivatives(): HasManyThrough
    {
        /**
         * TODO: If you end up using a none sqlite database, ->groupBy('vehicle_derivatives.id')
         * may pose as a problem that may need to be fixed
         */

        return $this->hasManyThrough(
            VehicleDerivative::class,
            Vehicle::class,
            'model_id', // Foreign key on the VehicleModel table...
            'id',
            'id',
            'year_id'
        )
            ->select('vehicle_derivatives.*')
            ->groupBy('vehicle_derivatives.id');
    }
}
