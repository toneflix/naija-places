<?php

namespace App\Models\World;

use App\Traits\PlaceFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;
    use PlaceFilter;
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
            'timezones' => \Illuminate\Database\Eloquent\Casts\AsCollection::class,
            'translations' => \Illuminate\Database\Eloquent\Casts\AsCollection::class,
        ];
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this
            ->where('iso2', $value)
            ->orWhere('id', (int)$value)
            ->orWhere('name', $value)
            ->firstOrFail();
    }

    /**
     * Retrieve the child model for a bound value.
     *
     * @param  string  $childType
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        if (in_array($childType, ['state'])) {
            return $this->{str($childType)->plural()->toString()}()
                ->where('iso2', $value)
                ->orWhere('id', (int)$value)
                ->orWhere('name', $value)
                ->firstOrFail();
        }
        return parent::resolveChildRouteBinding($childType, $value, $field);
    }

    /**
     * Get the Region the Country belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get all of the States for the Country
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    /**
     * Get the SubRegion the Country belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subregion(): BelongsTo
    {
        return $this->belongsTo(SubRegion::class);
    }
}
