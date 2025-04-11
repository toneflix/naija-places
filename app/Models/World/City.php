<?php

namespace App\Models\World;

use App\Traits\PlaceFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory;
    use PlaceFilter;
    use \App\Traits\ModelCanExtend;

    protected $table = 'world_cities';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'flag' => 'boolean',
        ];
    }

    /**
     * Get state for the City
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
