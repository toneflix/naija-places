<?php

namespace App\Http\Controllers\Auth;

use App\Enums\HttpStatus;
use App\Helpers\Providers as PV;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use DeviceDetector\DeviceDetector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {
        try {
            $user = $request->authenticate() ?: $request->user();

            return $this->setUserData($request, $user);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return PV::response()->error([
                'message' => $e->getMessage(),
                'errors' => [
                    'email' => $e->getMessage(),
                ],
            ], HttpStatus::UNPROCESSABLE_ENTITY);
        }
    }

    public function setUserData(Request|LoginRequest $request, User $user)
    {
        $device = $request->userAgent();
        $user->tokens()->where('name', $device)->delete();
        $token = $user->createToken($device, ['user:access']);

        $user->save();

        return PV::response()->success(new UserResource($user), HttpStatus::OK, [
            'message' => 'Login was successfull',
            'token' => $token->plainTextToken,
            'abilities' => $token->accessToken->abilities,
        ]);
    }

    public function getTokens(Request $request)
    {
        $tokens = $request->user()->tokens()
            ->get();

        $data = $tokens->map(function ($token) use ($request) {
            $dev = new DeviceDetector($token->name);
            $dev->parse();
            $os = $dev->getOs();
            $name = $os['name'] ?? 'Unknown Device';
            $version = $os['version'] ?? '0.00';
            $platform = in_array($dev->getBrandName(), ['Apple', 'Microsoft'])
                ? $dev->getBrandName()
                : (
                    in_array($dev->getOs('name'), ['Android', 'Ubuntu', 'Windows'])
                    ? $dev->getOs('name')
                    : (
                        $dev->getClient('type') === 'browser'
                        ? $dev->getClient('family')
                        : $dev->getBrandName()
                    )
                );

            return (object) [
                'id' => $token->id,
                'name' => collect([$dev->getBrandName(), $name, "(v{$version})"])->implode(' '),
                'platform' => $platform ?: 'Unknown Platform',
                'platform_id' => str($platform ?: 'question')->slug('-')->toString(),
                'current' => $token->id === $request->user()->currentAccessToken()->id,
                'last_used' => $token->last_used_at?->diffInHours() > 24
                    ? $token->last_used_at?->format('d M Y')
                    : $token->last_used_at?->diffForHumans(),
            ];
        });

        return PV::response()->success([
            'message' => 'Tokens retrieved successfully',
            'data' => $data,
        ], HttpStatus::OK);
    }

    /**
     * Destroy an authenticated session.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->user()->update([
            'last_seen' => now(),
        ]);


        if ($request->isXmlHttpRequest() || $request->is('api/*')) {
            $request->user()->currentAccessToken()->delete();
        } else {
            Auth::logout();
            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return response()->redirectToRoute('web.login');
        }


        return PV::response()->success([
            'message' => 'You have been successfully logged out',
        ], HttpStatus::OK);
    }

    /**
     * Destroy all selected authenticated sessions.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyTokens(Request $request)
    {
        $request->validate([
            'token_ids' => 'required|array',
        ], [
            'token_ids.required' => __('Please select at least one device to logout'),
        ]);

        $tokens = $request->user()->tokens()
            ->whereIn('id', $request->token_ids)
            ->whereNot('id', $request->user()->currentAccessToken()->id)
            ->get();

        $names = [];

        if ($tokens->count() > 0) {
            $names = $tokens->pluck('name')->map(function ($name) {
                $dev = new DeviceDetector($name);
                $dev->parse();
                $os = $dev->getOs();

                $osname = $os['name'] ?? 'Unknown Device';
                $osversion = $os['version'] ?? '0.00';

                return collect([$dev->getBrandName(), $osname, "(v{$osversion})"])->implode(' ');
            })->implode(', ');

            $tokens->each->delete();
        } else {
            return PV::response()->error([
                'message' => __('You are no longer logged in on any of the selected devices'),
            ], HttpStatus::UNPROCESSABLE_ENTITY);
        }

        return PV::response()->success([
            'message' => __('You have been successfully logged out of :0', [$names]),
        ], HttpStatus::OK);
    }

    /**
     * Authenticate the request for channel access.
     *
     * @return \Illuminate\Http\Response
     */
    public function broadcastingAuth(Request $request)
    {
        return Broadcast::auth($request);
    }
}
