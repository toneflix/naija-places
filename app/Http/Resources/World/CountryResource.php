<?php

namespace App\Http\Resources\World;

use Illuminate\Http\Request;
use ToneflixCode\ResourceModifier\Services\Json\JsonResource;

class CountryResource extends JsonResource
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
            "name" => $this->name,
            "iso3" => $this->iso3,
            "numeric_code" => $this->numeric_code,
            "iso2" => $this->iso2,
            "phonecode" => $this->phonecode,
            "capital" => $this->capital,
            "currency" => $this->currency,
            "currency_name" => $this->currency_name,
            "currency_symbol" => $this->currency_symbol,
            "tld" => $this->tld,
            "native" => $this->native,
            "region" => $this->region,
            "region_id" => $this->region_id,
            "subregion" => $this->subregion,
            "subregion_id" => $this->subregion_id,
            "nationality" => $this->nationality,
            "timezones" => $this->timezones,
            "translations" => $this->translations,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "emoji" => $this->emoji,
            "emoji_u" => $this->emoji_u,
            "flag" => $this->flag,
            "wiki_data_id" => $this->wiki_data_id,
            "created_at" => $this->created_at?->toString(),
            "updated_at" => $this->updated_at?->toString(),
        ];
    }
}
