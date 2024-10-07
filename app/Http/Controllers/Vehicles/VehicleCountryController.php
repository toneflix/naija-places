<?php

namespace App\Http\Controllers\Vehicles;

use App\Enums\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Vehicles\CountryCollection;
use App\Models\Vehicles\VehicleCountry;
use Illuminate\Http\Request;

class VehicleCountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = VehicleCountry::query();

        $list = $query->get();

        return (new CountryCollection($list))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleCountry $vehicleCountry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VehicleCountry $vehicleCountry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleCountry $vehicleCountry)
    {
        //
    }
}
