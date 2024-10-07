<?php

namespace App\Http\Resources\Vehicles;

use Illuminate\Http\Request;
use ToneflixCode\ResourceModifier\Services\Json\JsonResource;

class MileageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "vehicleId" => $this->vehicle_id,
            "cityFuelPer100kmL" => $this->city_fuel_per_100km_l,
            "highwayFuelPer100kmL" => $this->highway_fuel_per_100km_l,
            "mixedFuelConsumptionPer100kmL" => $this->mixed_fuel_consumption_per100km_l,
            "milesPerGallon" => $this->miles_per_gallon,
            "rangeKm" => $this->range_km,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
        ];
    }
}
