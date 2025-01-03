<?php

namespace App\Http\Controllers\Auth;

use App\Enums\HttpStatus;
use App\Helpers\Providers as PV;
use App\Http\Controllers\Controller;
use App\Models\PasswordCodeResets;
use App\Notifications\SendCode;
use Illuminate\Http\Request;
use Valorin\Random\Random;

class PasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email', 'exists:users'],
        ], [
            'email.exists' => 'We could not find a user with this email address.',
        ]);

        // Delete the old code
        PasswordCodeResets::whereEmail($request->email)->delete();

        // // generate the new code
        $reset = new PasswordCodeResets();
        $reset->email = $request->email;
        $reset->code = Random::otp(6);
        $reset->save();
        $reset->notify(new SendCode());

        // And finally return a response
        return PV::response()->success([
            'message' => __('We have sent you a message to help with recovering your password.'),
        ], HttpStatus::CREATED);
    }
}