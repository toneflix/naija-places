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
    public function index(Request $request)
    {
        @[
            'allowed' => $allowed,
            'banned' => $banned,
        ] = $this->validate($request, [
            'allowed' => ['nullable', 'string'],
            'banned' => ['nullable', 'string'],
        ]);

        $query = Country::query();

        $query->when($allowed, fn($q) => $q->onlyAllowed($allowed));
        $query->when($banned, fn($q) => $q->notBanned($banned));

        $countries = $query->get();

        return (new CountryCollection($countries))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }
}
