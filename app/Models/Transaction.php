<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reference',
        'discount',
        'user_id',
        'status',
        'method',
        'amount',
        'fees',
        'due',
    ];

    /**
     * The attributes to be appended
     *
     * @var array
     */
    protected $appends = [
        'type',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tax' => 'float',
            'due' => 'float',
            'fees' => 'float',
            'amount' => 'float',
            'webhook' => 'collection',
            'discount' => 'float',
        ];
    }

    /**
     * Get the transaction's transactable model (probably a fruit bay item).
     */
    public function transactable(): MorphTo
    {
        return $this->morphTo();
    }

    public function content(): Attribute
    {
        return new Attribute(
            get: fn () => $this->transactable()->get(),
        );
    }

    public function type(): Attribute
    {
        return new Attribute(
            get: fn () => str($this->transactable_type)->afterLast('\\'),
        );
    }

    /**
     * Get the user that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the temporary user that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tempUser(): BelongsTo
    {
        return $this->belongsTo(TempUser::class);
    }
}
