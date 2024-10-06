<?php

namespace App\Http\Controllers\World;

use App\Enums\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\World\SubRegionCollection;
use App\Models\World\SubRegion;
use Illuminate\Http\Request;

class SubRegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = SubRegion::query();

        $sub_regions = $query->get();

        return (new SubRegionCollection($sub_regions))->additional([
            'status' => 'success',
            'message' => HttpStatus::message(HttpStatus::OK),
            'statusCode' => HttpStatus::OK,
        ]);
    }
}
