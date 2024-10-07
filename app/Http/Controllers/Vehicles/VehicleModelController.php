<?php

namespace App\Http\Controllers\Vehicles;

use App\Enums\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Vehicles\ModelCollection;
use App\Models\Vehicles\VehicleManufacturer;
use App\Models\Vehicles\VehicleModel;
use Illuminate\Http\Request;

class VehicleModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = VehicleModel::query();

        $query->when(
            $request->has('search'),
            fn($q) => $q->where('vehicle_models.name', 'like', "%{$request->search}%")
        );

        $list = $query
            ->orderBy('name')
            ->paginate($request->input('limit', 50));

        return (new ModelCollection($list))->additional([
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
        $query = $manufacturer->models()->getQuery();

        $query->when(
            $request->has('search'),
            fn($q) => $q->where('vehicle_models.name', 'like', "%{$request->search}%")
        );

        $list = $query
            ->orderBy('name')
            ->paginate($request->input('limit', 50));

        return (new ModelCollection($list))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }
}
