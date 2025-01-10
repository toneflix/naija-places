<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use ToneflixCode\ResourceModifier\Services\Json\JsonResource;

class UnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $with = str($request->input('with'))->replace(', ', ',')->explode(',');

        return [
            'id' => $this->id,
            'iso2' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'lga' => $this->lga->name,
            'lgaId' => $this->lga->id,
            'ward' => $this->ward->name,
            'wardId' => $this->ward->id,
            'state' => $this->state->name,
            'stateId' => $this->state->id,
            $this->mergeWhen($with->contains('timestamps'), [
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ])
        ];
    }
}
