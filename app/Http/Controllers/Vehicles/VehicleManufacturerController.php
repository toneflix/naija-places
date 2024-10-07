<?php

namespace App\Http\Controllers\Vehicles;

use App\Enums\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Vehicles\ManufacturerCollection;
use App\Models\Vehicles\VehicleCountry;
use App\Models\Vehicles\VehicleManufacturer;
use App\Models\Vehicles\VehicleYear;
use Illuminate\Http\Request;

class VehicleManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = VehicleManufacturer::query();

        $query->when(
            $request->has('search'),
            fn($q) => $q->where('name', 'like', "%{$request->search}%")
        );

        $list = $query
            ->orderBy('name')
            ->paginate($request->input('limit', 50));

        return (new ManufacturerCollection($list))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function yearIndex(Request $request, VehicleYear $year)
    {
        $query = $year->manufacturers()->getQuery();

        $query->when(
            $request->has('search'),
            fn($q) => $q->where('name', 'like', "%{$request->search}%")
        );

        $list = $query
            ->orderBy('name')
            ->paginate($request->input('limit', 50));

        return (new ManufacturerCollection($list))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function countryIndex(Request $request, VehicleCountry $country)
    {
        $query = $country->manufacturers()->getQuery();

        $query->when(
            $request->has('search'),
            fn($q) => $q->where('name', 'like', "%{$request->search}%")
        );

        $list = $query
            ->orderBy('name')
            ->paginate($request->input('limit', 50));

        return (new ManufacturerCollection($list))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function yearCountryIndex(Request $request, VehicleYear $year, string $country)
    {
        $query = $year->manufacturers()->getQuery();

        $query
            ->when(
                $request->has('search'),
                fn($q) => $q->where('vehicle_manufacturers.name', 'like', "%{$request->search}%")
            )
            ->where('vehicles.country_id', $country);

        $list = $query
            ->orderBy('name')
            ->paginate($request->input('limit', 50));

        return (new ManufacturerCollection($list))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }
}
