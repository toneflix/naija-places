<?php

namespace App\Http\Resources\Vehicles;

use Illuminate\Http\Request;
use ToneflixCode\ResourceModifier\Services\Json\ResourceCollection;

class YearCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
