<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StateResource extends JsonResource
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
            'slug' => $this->slug,
            'name' => $this->name,
            'code' => $this->code,
            $this->mergeWhen($with->contains('timestamps'), [
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ])
        ];
    }
}