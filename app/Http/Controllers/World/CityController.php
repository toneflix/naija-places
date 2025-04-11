<?php

namespace App\Http\Controllers\World;

use App\Enums\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\World\CityCollection;
use App\Models\World\Country;
use App\Models\World\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Country $country, State $state)
    {
        @[
            'allowed' => $allowed,
            'banned' => $banned,
        ] = $this->validate($request, [
            'allowed' => ['nullable', 'string'],
            'banned' => ['nullable', 'string'],
        ]);

        $query = $state->cities();

        $query->when($allowed, fn($q) => $q->onlyAllowed($allowed, 'id'));
        $query->when($banned, fn($q) => $q->notBanned($banned, 'id'));

        $cities = $query->get();

        return (new CityCollection($cities))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }
}
