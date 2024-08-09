<?php

namespace App\Http\Controllers\Auth;

use App\Enums\HttpStatus;
use App\Helpers\Providers as PV;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use DeviceDetector\DeviceDetector;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required_without:firstname', 'string', 'max:255'],
            'email' => ['required_without:phone', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => 'required_without:email|string|max:255|unique:users,phone',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'firstname' => ['nullable', 'string', 'max:255'],
            'laststname' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required_without' => 'Please enter your fullname.',
        ], [
            'email' => 'Email Address',
            'phone' => 'Phone Number',
        ]);

        $user = $this->createUser($request);

        return $this->setUserData($request, $user);
    }

    /**
     * Create a new user based on the provided data.
     *
     * @return \App\Models\User
     */
    public function createUser(Request $request)
    {
        $firstname = str($request->get('name'))->explode(' ')->first(null, $request->firstname);
        $lastname = str($request->get('name'))->explode(' ')->last(fn ($n) => $n !== $firstname, $request->lastname);

        $user = User::create([
            'role' => 'user',
            'type' => $request->get('type', 'farmer'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'password' => $request->get('password'),
            'lastname' => $request->get('lastname', $lastname ?? ''),
            'firstname' => $request->get('firstname', $firstname),
            'email_verified_at' => ! PV::config('verify_email', false) ? now() : null,
            'phone_verified_at' => ! PV::config('verify_phone', false) ? now() : null,
        ]);

        return $user;
    }

    public function setUserData(Request $request, User $user)
    {
        event(new Registered($user));

        $dev = new DeviceDetector($request->userAgent());

        $device = $dev->getBrandName()
            ? ($dev->getBrandName().$dev->getDeviceName())
            : $request->userAgent();

        $user->save();

        $token = $user->createToken($device, ['user:access'])->plainTextToken;

        return $this->preflight($token);
    }

    /**
     * Log the newly registered user in.
     *
     * @param  string  $token
     * @return \App\Http\Resources\UserResource
     */
    public function preflight($token)
    {
        [$id, $user_token] = explode('|', $token, 2);

        $token_data = DB::table('personal_access_tokens')->where('token', hash('sha256', $user_token))->first();

        $user_id = $token_data->tokenable_id;

        Auth::loginUsingId($user_id);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        /** @var \Carbon\Carbon */
        $datetime = $user->last_attempt ?? now()->subSeconds(PV::config('token_lifespan', 30) + 1);
        $dateAdd = $datetime->addSeconds(PV::config('token_lifespan', 30));
        // dd($dateAdd->format('H:i:s'));

        return PV::response()->success(new UserResource($user), HttpStatus::CREATED, [
            'message' => 'Registration was successfull',
            'token' => $token,
            'time_left' => $dateAdd->shortAbsoluteDiffForHumans(),
            'try_at' => $dateAdd->toDateTimeLocalString(),
        ]);
    }
}
