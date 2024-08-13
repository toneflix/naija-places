<?php

namespace App\Models;

use App\Helpers\Providers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Valorin\Random\Random;

class ApiKey extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rate_limited',
    ];

    /**
     * The model's attributes.
     *
     * @var array<string, string>
     */
    protected $attributes = [
        'rate_limit' => 0,
        'rate_limited' => false,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'meta' => \Illuminate\Database\Eloquent\Casts\AsCollection::class,
            'rate_limit' => 'integer',
            'rate_limited' => 'boolean',
        ];
    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            $model->key = Random::token();
            $model->rate_limit = Providers::config('default_rate_limit');
        });

        static::created(function (self $model) {
            $model->rate_limit = Providers::config('default_rate_limit');
            $model->saveQuietly();
        });
    }

    /**
     * Get the user that owns the ApiKey
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}