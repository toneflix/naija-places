<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use ToneflixCode\ResourceModifier\Services\Json\JsonResource;

class ApiKeyResource extends JsonResource
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
            'key' => $request->isMethod('POST') ? $this->key : str($this->key)->mask('*', strlen($this->key) / 5),
            'name' => $this->name,
            'rateLimit' => $this->rate_limit,
            'createdAt' => $this->created_at,
            'createDate' => $this->created_at?->format('Y-m-d'),
            'rateLimited' => $this->rate_limited,
        ];
    }
}
