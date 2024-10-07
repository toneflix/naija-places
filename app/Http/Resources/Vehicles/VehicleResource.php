<?php

namespace App\Http\Resources\Vehicles;

use Illuminate\Http\Request;
use stdClass;
use ToneflixCode\ResourceModifier\Services\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $with = str($request->with ?: '')->remove(' ')->explode(',');

        return [
            "id" => $this->id,
            "name" => join(' ', [$this->model->name, $this->model->generation]),
            "model" => $this->model->name,
            "generation" => $this->model->generation,
            "year" => $this->year->year_from,
            "country" => $this->country->name,
            "derivative" => $this->derivative->name,
            "doors" => $this->number_of_doors,
            "class" => $this->car_class,
            "engine" => $this->when($with->contains('engine'), fn() => new EngineResource($this->engine), new stdClass()),
            "mileage" => $this->when($with->contains('mileage'), fn() => new MileageResource($this->mileage), new stdClass()),
            "fuel_type" => $this->whenLoaded('engine', function () {
                return data_get([
                    '' => 'electric',
                    'diesel' => 'diesel',
                    'petrol' => 'gasoline',
                    'gasoline' => 'gasoline',
                ], str($this->engine->engine_type ?: '')->lower(), $this->engine->engine_type);
            }),
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
        ];
    }
}