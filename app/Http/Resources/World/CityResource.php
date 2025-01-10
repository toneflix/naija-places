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
            "state_id" => $this->stateId,
            "state_code" => $this->stateCode,
            "country_id" => $this->countryId,
            "country_code" => $this->countryCode,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "created_at" => $this->createdAt,
            "updated_at" => $this->updatedAt,
            "flag" => $this->flag,
            "wiki_data_id" => $this->wikiDataId,
        ];
    }
}
