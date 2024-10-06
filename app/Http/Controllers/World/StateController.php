<?php

namespace App\Http\Controllers\World;

use App\Enums\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\World\StateCollection;
use App\Models\World\Country;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Country $country)
    {
        $query = $country->states();

        $states = $query->orderBy('name')->get();

        return (new StateCollection($states))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }
}
