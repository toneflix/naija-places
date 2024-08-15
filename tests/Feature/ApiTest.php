<?php

namespace Tests\Feature;

use App\Http\Resources\LgaResource;
use App\Http\Resources\StateResource;
use App\Http\Resources\UnitResource;
use App\Http\Resources\WardResource;
use App\Models\Lga;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(
            ThrottleRequests::class
        );
    }

    /**
     * A basic feature test example.
     */
    public function testRequestsCanBeRateLimited(): void
    {
        $this->withMiddleware(
            ThrottleRequests::class
        );

        for ($i = 0; $i < 100; $i++) {
            $response = $this->get('/api/');
        }
        $response->assertTooManyRequests();
    }

    public function testCanLoadStates(): void
    {
        $response = $this->get('/api/v1/states/', [
            'Referer' => 'https://naija-places.toneflix.com.ng/tests'
        ]);
        $response->assertOk();
        $this->assertSame(
            $response->json('data')[0],
            (new StateResource(State::first()))->resolve()
        );
    }

    public function testCanLoadLgas(): void
    {
        $state = State::first();

        $response = $this->get("/api/v1/states/{$state->id}/lgas", [
            'Referer' => 'https://naija-places.toneflix.com.ng/tests'
        ]);
        $response->assertOk();
        $this->assertSame(
            $response->json('data')[0],
            (new LgaResource($state->lgas->first()))->resolve()
        );
    }

    public function testCanLoadWards(): void
    {
        $state = State::first();
        $lga = $state->lgas()->first();

        $response = $this->get("/api/v1/states/{$state->id}/lgas/{$lga->id}/wards", [
            'Referer' => 'https://naija-places.toneflix.com.ng/tests'
        ]);
        $response->assertOk();
        $this->assertSame(
            $response->json('data')[0],
            (new WardResource($lga->wards->first()))->resolve()
        );
    }

    public function testCanLoadWardPollingUnits(): void
    {
        $state = State::first();
        $lga = $state->lgas()->first();
        $ward = $lga->wards()->first();

        $response = $this->get("/api/v1/states/{$state->id}/lgas/{$lga->id}/wards/{$ward->id}/units", [
            'Referer' => 'https://naija-places.toneflix.com.ng/tests'
        ]);
        $response->assertOk();
        $this->assertSame(
            $response->json('data')[0],
            (new UnitResource($ward->units->first()))->resolve()
        );
    }

    public function testCanLoadCities(): void
    {
        $state = State::first()->id;

        $response = $this->get("/api/v1/states/{$state}/cities", [
            'Referer' => 'https://naija-places.toneflix.com.ng/tests'
        ]);
        $response->assertOk();
    }
}
