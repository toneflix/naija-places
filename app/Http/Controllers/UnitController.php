<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatus;
use App\Http\Resources\UnitCollection;
use App\Models\Lga;
use App\Models\State;
use App\Models\Ward;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index(Request $request, State $state, Lga $lga, Ward $ward)
    {
        $query = $ward->units()->getQuery();

        $lgas = $query->get();

        return (new UnitCollection($lgas))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }
}
