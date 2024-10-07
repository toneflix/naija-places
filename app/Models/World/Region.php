<?php

namespace App\Models\World;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use HasFactory;
    use \App\Traits\ModelCanExtend;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'flag' => 'boolean',
            'translations' => \Illuminate\Database\Eloquent\Casts\AsCollection::class,
        ];
    }

    /**
     * Get all of the SubRegion for the Region
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subregions(): HasMany
    {
        return $this->hasMany(SubRegion::class);
    }

    /**
     * Get all of the Country for the Region
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function countries(): HasMany
    {
        return $this->hasMany(Country::class);
    }
}