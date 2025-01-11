<?php

namespace App\Http\Controllers\Account;

use App\Enums\HttpStatus;
use App\Helpers\Providers;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiKeyCollection;
use App\Http\Resources\ApiKeyResource;
use App\Models\ApiKey;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user('sanctum');

        $query = $user->apiKeys()->getQuery();

        $keys = $query->paginate($request->input('limit', 30));

        return (new ApiKeyCollection($keys));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|max:15'
        ]);

        /** @var \App\Models\User $user */
        $user = $request->user('sanctum');

        $key = $user->apiKeys()->make();
        $key->name = $request->name;
        $key->rate_limit = 0;
        $key->save();

        return (new ApiKeyResource($key))->response()->setStatusCode(HttpStatus::CREATED->value);
    }

    /**
     * Display the specified resource.
     */
    public function show(ApiKey $api_key)
    {
        return (new ApiKeyResource($api_key));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApiKey $apiKey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApiKey $api_key)
    {
        $api_key->delete();

        return (new ApiKeyCollection([]))->response()->setStatusCode(HttpStatus::ACCEPTED->value);
    }
}
