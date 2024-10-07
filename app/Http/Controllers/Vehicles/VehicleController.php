<?php

namespace App\Http\Controllers\Vehicles;

use App\Enums\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Vehicles\VehicleCollection;
use App\Models\Vehicles\Vehicle;
use App\Models\Vehicles\VehicleManufacturer;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Vehicle::query();

        $query->when(
            $request->has('search'),
            fn($q) => $q->where('vehicles.name', 'like', "%{$request->search}%")
        );

        $list = $query
            ->orderBy('name')
            ->paginate($request->input('limit', 50));

        return (new VehicleCollection($list))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function manufacturerIndex(Request $request, VehicleManufacturer $manufacturer)
    {
        $query = $manufacturer->vehicles()->getQuery();

        $query->when(
            $request->has('search'),
            fn($q) => $q->where('vehicles.name', 'like', "%{$request->search}%")
        );

        $list = $query
            ->orderBy('name')
            ->paginate($request->input('limit', 50));

        return (new VehicleCollection($list))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }
}
