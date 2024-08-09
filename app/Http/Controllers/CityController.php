<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatus;
use App\Http\Resources\CityCollection;
use App\Models\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request, State $state)
    {
        $query = $state->cities()->getQuery();

        $lgas = $query->get();

        return (new CityCollection($lgas))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'status_code' => HttpStatus::OK,
        ]);
    }
}
