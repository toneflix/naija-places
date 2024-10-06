<?php

namespace App\Http\Controllers\World;

use App\Enums\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\World\CountryCollection;
use App\Models\World\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Country::query();

        $countries = $query->get();

        return (new CountryCollection($countries))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }
}
