<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class PasswordCodeResets extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'email',
        'phone',
        'code',
        'created_at',
    ];

    public static function boot(): void
    {
        parent::boot();
        static::created(function ($model) {
            $model->user->last_attempt = now();
            $model->user->save();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
