<?php

namespace App\Http\Resources\Vehicles;

use Illuminate\Http\Request;
use ToneflixCode\ResourceModifier\Services\Json\JsonResource;

class YearResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'year' => $this->year_from,
            'period' => join(' - ', [$this->year_from, $this->year_to]),
            'year_from' => $this->year_from,
            'year_to' => $this->year_to,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
