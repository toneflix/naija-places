<?php

namespace App\Http\Controllers\Vehicles;

use App\Enums\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\GenericCollection;
use App\Http\Resources\Vehicles\YearCollection;
use App\Models\Vehicles\VehicleCountry;
use App\Models\Vehicles\VehicleYear;
use Illuminate\Http\Request;

class VehicleYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = VehicleYear::query();

        $query
            ->when(
                $request->has('min'),
                fn($q) => $q->where('year_from', '>=', $request->min)
            )->when(
                $request->has('max'),
                fn($q) => $q->where('year_to', '<=', $request->max)
            );

        if ($request->boolean('distinct')) {
            $list = $query
                ->where('year_from', '!=', '')
                ->select(['vehicle_years.id', 'year_from as year'])
                ->groupBy(['year_from'])
                ->orderBy('year_from')
                ->paginate($request->input('limit', 50));

            return (new GenericCollection($list))->additional([
                'status' => 'success',
                'message' => HttpStatus::message(HttpStatus::OK),
                'statusCode' => HttpStatus::OK,
            ]);
        }

        $list = $query
            ->orderBy('year_from')
            ->paginate($request->input('limit', 50));

        return (new YearCollection($list))->additional([
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
        $query = $country->years()->getQuery();
        $query
            ->when(
                $request->has('min'),
                fn($q) => $q->where('year_from', '>=', $request->min)
            )->when(
                $request->has('max'),
                fn($q) => $q->where('year_to', '<=', $request->max)
            );

        if ($request->boolean('distinct')) {
            $list = $query
                ->where('year_from', '!=', '')
                ->select(['vehicle_years.id', 'year_from as year'])
                ->groupBy(['year_from'])
                ->orderBy('year_from')
                ->paginate($request->input('limit', 50));

            return (new GenericCollection($list))->additional([
                'status' => 'success',
                'message' => HttpStatus::message(HttpStatus::OK),
                'statusCode' => HttpStatus::OK,
            ]);
        }

        $list = $query
            ->orderBy('year_from')
            ->paginate($request->input('limit', 50));

        return (new YearCollection($list))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }
}
