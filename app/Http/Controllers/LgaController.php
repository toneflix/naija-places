<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatus;
use App\Http\Resources\LgaCollection;
use App\Models\State;
use Illuminate\Http\Request;

class LgaController extends Controller
{
    public function index(Request $request, State $state)
    {
        $query = $state->lgas()->getQuery();

        $lgas = $query->get();

        return (new LgaCollection($lgas))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'status_code' => HttpStatus::OK,
        ]);
    }
}
