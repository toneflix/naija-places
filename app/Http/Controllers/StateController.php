<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatus;
use App\Http\Resources\StateCollection;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(Request $request)
    {
        $query = State::query();

        $states = $query->get();

        return (new StateCollection($states))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }
}
