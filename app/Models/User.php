<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\SendCode;
use App\Traits\ModelCanExtend;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use ToneflixCode\LaravelFileable\Traits\Fileable;
use Valorin\Random\Random;

class User extends Authenticatable
{
    use Fileable;
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use ModelCanExtend;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'address',
        'country',
        'state',
        'city',
        'email',
        'phone',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'data',
        'password',
        'remember_token',
        'access_data',
        'email_verify_code',
        'phone_verify_code',
    ];

    /**
     * The model's attributes.
     *
     * @var array<string, string>
     */
    protected $attributes = [
        'data' => '{}',
        'access_data' => '{}',
    ];

    /**
     * The attributes to be appended
     *
     * @var array
     */
    protected $appends = [
        'user_data',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'data' => \Illuminate\Database\Eloquent\Casts\AsCollection::class,
            'access_data' => \Illuminate\Database\Eloquent\Casts\AsCollection::class,
            'last_attempt' => 'datetime',
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
        ];
    }

    public function registerFileable()
    {
        $this->fileableLoader([
            'image' => 'avatar',
        ], 'default', true);
    }

    public static function registerEvents()
    {
        static::creating(function (User $model) {
            $model->username ??= $model->generateUsername($model->firstname);
        });
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)
            ->orWhere('username', $value)
            ->firstOrFail();
    }

    /**
     * Get the user's fullname.
     *
     * @return string
     */
    protected function fullname(): Attribute
    {
        return Attribute::make(
            get: fn () => collect([$this->firstname, $this->lastname])->join(' '),
        );
    }

    public function hasVerifiedPhone()
    {
        return $this->phone_verified_at !== null;
    }

    /**
     * Send the email verification message
     */
    public function sendEmailVerificationNotification()
    {
        $this->last_attempt = now();
        $this->email_verify_code = Random::otp(6);
        $this->save();

        $this->notify(new SendCode($this->email_verify_code, 'verify'));
    }

    /**
     * Send the phone verification message
     */
    public function sendPhoneVerificationNotification()
    {
        $this->last_attempt = now();
        $this->phone_verify_code = Random::otp(6);
        $this->save();

        $this->notify(new SendCode($this->phone_verify_code, 'verify-phone'));
    }

    public function markEmailAsVerified()
    {
        $this->last_attempt = null;
        $this->email_verify_code = null;
        $this->email_verified_at = now();
        $this->save();

        if ($this->wasChanged('email_verified_at')) {
            return true;
        }

        return false;
    }

    public function markPhoneAsVerified()
    {
        $this->last_attempt = null;
        $this->phone_verify_code = null;
        $this->phone_verified_at = now();
        $this->save();

        if ($this->wasChanged('phone_verified_at')) {
            return true;
        }

        return false;
    }

    /**
     * Get all of the transactions for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the user's fullname.
     *
     * @return string
     */
    protected function userData(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data,
            set: fn ($value) => is_array($value)
                ? json_encode($value, JSON_FORCE_OBJECT)
                : $value,
        );
    }

    /**
     * Get temporary User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function temp(): BelongsTo
    {
        return $this->belongsTo(TempUser::class, 'email', 'email');
    }
}
