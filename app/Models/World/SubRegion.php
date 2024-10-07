<?php

namespace App\Models\World;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubRegion extends Model
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
     * Get all of the Region for the Country
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}