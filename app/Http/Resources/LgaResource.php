<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use ToneflixCode\ResourceModifier\Services\Json\JsonResource;

class LgaResource extends JsonResource
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
            'iso2' => $this->code,
            'slug' => $this->slug,
            'name' => $this->name,
            'code' => $this->code,
            'state' => $this->state->name,
            'stateId' => $this->state->id,
            $this->mergeWhen($with->contains('timestamps'), [
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ])
        ];
    }
}
