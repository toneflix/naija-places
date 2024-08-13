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

        $wards = $query->get();

        return (new WardCollection($wards))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }
}