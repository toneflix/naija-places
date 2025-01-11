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
        $with = str($request->input('with'))->replace(', ', ',')->explode(',');

        return [
            'id' => $this->id,
            'key' => $request->isMethod('POST') ? $this->key : str($this->key)->mask('*', strlen($this->key) / 5),
            'name' => $this->name,
            'rateLimit' => $this->rate_limit,
            'createdAt' => $this->created_at,
            'createDate' => $this->created_at?->format('Y-m-d'),
            'log' => $this->log,
            'rateLimited' => $this->rate_limited,
            'stats' => $this->when($with->contains('stats'), fn() => [
                'totalCalls' => $this->calls['total'] ?? 0,
                'dailyCalls' => $this->calls['daily'] ?? 0,
                'monthlyCalls' => $this->calls['monthly'] ?? 0,
                'topEndpoint' => $this->calls['top_endpoint'] ?? '',
                'dailyTopEndpoint' => $this->calls['daily_top_endpoint'] ?? '',
                'topOrigin' => $this->calls['top_origin'] ?? '',
                'dailyTopOrigin' => $this->calls['daily_top_origin'] ?? '',
            ])
        ];
    }
}