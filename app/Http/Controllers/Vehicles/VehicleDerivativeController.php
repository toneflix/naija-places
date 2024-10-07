<?php

namespace App\Http\Controllers\Vehicles;

use App\Enums\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Vehicles\DerivativeCollection;
use App\Models\Vehicles\VehicleDerivative;
use App\Models\Vehicles\VehicleModel;
use Illuminate\Http\Request;

class VehicleDerivativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = VehicleDerivative::query();

        $query->when(
            $request->has('search'),
            fn($q) => $q->where('vehicle_derivatives.name', 'like', "%{$request->search}%")
        );

        $list = $query
            ->orderBy('name')
            ->paginate($request->input('limit', 50));

        return (new DerivativeCollection($list))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function modelIndex(Request $request, VehicleModel $model)
    {
        $query = $model->derivatives()->getQuery();

        $query->when(
            $request->has('search'),
            fn($q) => $q->where('vehicle_derivatives.name', 'like', "%{$request->search}%")
        );

        $list = $query
            ->orderBy('name')
            ->paginate($request->input('limit', 50));

        return (new DerivativeCollection($list))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }
}
