<?php

namespace App\Http\Controllers\World;

use App\Enums\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\World\StateCollection;
use App\Http\Resources\World\StateResource;
use App\Models\World\Country;
use App\Models\World\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Country $country)
    {
        @[
            'allowed' => $allowed,
            'banned' => $banned,
        ] = $this->validate($request, [
            'allowed' => ['nullable', 'string'],
            'banned' => ['nullable', 'string'],
        ]);

        $query = $country->states();

        $query->when($allowed, fn($q) => $q->onlyAllowed($allowed));
        $query->when($banned, fn($q) => $q->notBanned($banned));

        $states = $query->orderBy('name')->get();

        return (new StateCollection($states))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }

    public function show(Country $country, State $state)
    {
        return (new StateResource($state))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }
}
