<?php

namespace App\Http\Controllers\Auth;

use App\Enums\HttpStatus;
use App\Helpers\Providers as PV;
use App\Helpers\Url;
use App\Http\Controllers\Controller;
use App\Models\PasswordCodeResets;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $code = Url::base64urlDecode($request->code);

        if (str($code)->contains('|')) {
            $code = str($code)->explode('|')->first();
            $error = 'The link you followed has expired, please request a new reset link.';
        } else {
            $code = $request->code;
            $error = 'The code you provided has expired or does not exist.';
        }

        // find the code
        $code = PasswordCodeResets::firstWhere('code', $code);

        // check if it has not expired: the default time is 30 seconds
        if (!$code || $code->created_at->diffInSeconds(now()) >= PV::config('token_lifespan', 30)) {
            $code && $code->delete();

            return PV::response()->error([
                'message' => 'An error occured.',
                'errors' => ['code' => __($error)],
            ], HttpStatus::ACCEPTED);
        }

        // find user's email
        $user = User::firstWhere('email', $code->email);

        // Here we will attempt to reset the user's password.
        $user->update(['password' => $request->password]);

        // delete current code
        $code->delete();

        return PV::response()->success([
            'message' => __('Your password has successfully been chaged.'),
        ], HttpStatus::ACCEPTED);
    }

    /**
     * Handle an incoming check password request.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required'],
        ]);

        if ($validator->fails()) {
            return PV::response()->error([
                'message' => $validator->errors()->first() ?: 'Your input has a few errors',
                'errors' => $validator->errors(),
            ], HttpStatus::UNPROCESSABLE_ENTITY);
        }

        $code = Url::base64urlDecode($request->code);

        if (str($code)->contains('|')) {
            $code = str($code)->explode('|')->first();
            $error = 'The link you followed has expired, please request a new reset link.';
        } else {
            $code = $request->code;
            $error = 'The code you provided has expired or does not exist.';
        }

        // find the code
        $code = PasswordCodeResets::firstWhere('code', $code);

        // check if it has not expired: the default time is 30 seconds
        if (!$code || $code->created_at->diffInSeconds(now()) >= PV::config('token_lifespan', 30)) {
            $code && $code->delete();

            return PV::response()->error([
                'message' => 'An error occured.',
                'errors' => ['code' => __($error)],
            ], HttpStatus::UNPROCESSABLE_ENTITY);
        }

        return PV::response()->success([
            'message' => 'Your reset code is valid, you can change your password now.',
        ], HttpStatus::ACCEPTED);
    }
}
