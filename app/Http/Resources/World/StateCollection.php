<?php

namespace App\Http\Resources\World;

use Illuminate\Http\Request;
use ToneflixCode\ResourceModifier\Services\Json\ResourceCollection;

class StateCollection extends ResourceCollection
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
