<?php

namespace App\Http\Resources\World;

use Illuminate\Http\Request;
use ToneflixCode\ResourceModifier\Services\Json\JsonResource;

class CityResource extends JsonResource
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
            'iso2' => (string)$this->id,
            "name" => $this->name,
            "state_id" => $this->state_id,
            "state_code" => $this->state_code,
            "country_id" => $this->country_id,
            "country_code" => $this->country_code,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "flag" => $this->flag,
            "wiki_data_id" => $this->wiki_data_id,
            "created_at" => $this->created_at?->toString(),
            "updated_at" => $this->updated_at?->toString(),
        ];
    }
}
