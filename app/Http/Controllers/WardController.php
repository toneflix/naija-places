<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatus;
use App\Http\Resources\WardCollection;
use App\Models\Lga;
use App\Models\State;
use Illuminate\Http\Request;

class WardController extends Controller
{
    public function index(Request $request, State $state, Lga $lga)
    {
        $query = $lga->wards()->getQuery();

        $lgas = $query->get();

        return (new WardCollection($lgas))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'status_code' => HttpStatus::OK,
        ]);
    }
}
