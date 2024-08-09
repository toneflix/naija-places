<?php

namespace App\Models;

use App\Casts\ConfigValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Configuration extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'value' => ConfigValue::class,
            'secret' => 'boolean',
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'value',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'type' => 'string',
        'count' => null,
        'max' => null,
        'col' => 12,
        'autogrow' => false,
        'hint' => '',
        'secret' => false,
    ];

    public static function boot(): void
    {
        parent::boot();

        self::saved(function () {
            Cache::forget('configuration::build');
        });
    }

    /**
     * Set the specified configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param array<string, mixed>|string|null  $key
     * @param mixed $value
     * @param boolean $loadSecret
     * @return  \Illuminate\Support\Collection
     */
    public static function set(
        string|array|null $key = null,
        mixed $value = null,
        bool $loadSecret = false
    ) {
        if (is_array($key)) {
            foreach ($key as $k => $value) {
                Configuration::where('key', $k)->update(['value' => $value]);
            }
        } else {
            Configuration::where('key', $key)->update(['value' => $value]);
        }

        Cache::forget('configuration::build');

        return Configuration::build($loadSecret);
    }

    public static function build($loadSecret = false)
    {
        if ($loadSecret) {
            return Configuration::all()->mapWithKeys(function ($item) {
                return [$item->key => $item->value];
            });
        }

        /** @var \Illuminate\Support\Collection<TMapWithKeysKey, TMapWithKeysValue> $config */
        $config = Cache::remember('configuration::build', null, function () {
            return Configuration::all()->filter(fn ($conf) => !$conf->secret)->mapWithKeys(function ($item) {
                return [$item->key => $item->value];
            });
        });

        return $config;
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
