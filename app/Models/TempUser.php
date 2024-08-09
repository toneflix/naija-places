<?php

namespace App\Models;

use App\Traits\ModelCanExtend;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class TempUser extends Model
{
    use HasFactory;
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
    ];

    public static function boot(): void
    {
        parent::boot();
        self::deleting(function (TempUser $tempuser) {
            /** @var User */
            $user = User::whereEmail($tempuser->email)->first();
            if ($user && $tempuser->transactions()->count() > 0) {
                $tempuser->transactions->each(function (Transaction $transaction) use ($user) {
                    $transaction->user_id = $user->id;
                    $transaction->temp_user_id = null;
                    $transaction->save();
                });
            }
        });
    }

    public static function createUser(array | Collection $data): self
    {
        if (empty($data['email'])) {
            throw ValidationException::withMessages([
                'email' => "Email is required.",
            ]);
        }

        $fname = str($data['name'])->explode(' ')->first(null, $data['firstname'] ?? '');
        $lname = str($data['name'])->explode(' ')->last(fn ($n) => $n !== $fname, $data['lastname'] ?? '');

        /** @var \App\Models\TempUser $user */
        return static::updateOrCreate(
            [
                'email' =>  $data['email'],
            ],
            [
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'lastname' => $data['lastname'] ?? $lname ?? '',
                'firstname' => $data['firstname'] ?? $fname,
                'city' => $data['city'] ?? null,
                'state' => $data['state'] ?? null,
                'country' => $data['country'] ?? null,
                'address' => $data['address'] ?? null,
            ]
        );
    }

    /**
    * Get the user's fullname .
    *
    * @return string
    */
    protected function fullname(): Attribute
    {
        return Attribute::make(
            get: fn () => collect([$this->firstname, $this->lastname])->join(' '),
        );
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
}
