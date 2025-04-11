<?php

namespace Tests\Feature;

use App\Http\Resources\World\CityResource;
use App\Http\Resources\World\CountryResource;
use App\Http\Resources\World\StateResource;
use App\Models\World\City;
use App\Models\World\Country;
use App\Models\World\State;
use Tests\TestCase;

class FilterableTest extends TestCase
{
    public function testCanHideBannedCountries(): void
    {
        $response = $this->get('/api/v1/countries?banned=us', [
            'Referer' => 'https://naija-places.toneflix.com.ng/tests'
        ]);

        $response->assertOk();

        $this->assertNull(
            collect($response->json('data'))->firstWhere('iso2', 'US'),
        );
    }

    public function testCanLoadOnlyAllowedCountries(): void
    {
        $response = $this->get('/api/v1/countries?allowed=ng,gh', [
            'Referer' => 'https://naija-places.toneflix.com.ng/tests'
        ]);

        $response->assertOk();

        $this->assertSame(
            collect($response->json('data'))->firstWhere('iso2', 'GH'),
            (new CountryResource(Country::whereIso2('GH')->first()))->resolve()
        );

        $this->assertSame(
            collect($response->json('data'))->firstWhere('iso2', 'NG'),
            (new CountryResource(Country::whereIso2('NG')->first()))->resolve()
        );
    }

    public function testFiltersAreCaseInsensitive(): void
    {
        $response = $this->get('/api/v1/countries?banned=us', [
            'Referer' => 'https://naija-places.toneflix.com.ng/tests'
        ]);

        $response->assertOk();

        $this->assertNull(
            collect($response->json('data'))->firstWhere('iso2', 'US'),
        );

        $response = $this->get('/api/v1/countries?banned=US', [
            'Referer' => 'https://naija-places.toneflix.com.ng/tests'
        ]);

        $response->assertOk();

        $this->assertNull(
            collect($response->json('data'))->firstWhere('iso2', 'US'),
        );

        $response = $this->get('/api/v1/countries?allowed=ng,gh', [
            'Referer' => 'https://naija-places.toneflix.com.ng/tests'
        ]);

        $response->assertOk();

        $this->assertSame(
            collect($response->json('data'))->firstWhere('iso2', 'GH')['id'],
            (new CountryResource(Country::whereIso2('GH')->first()))->resolve()['id']
        );

        $this->assertSame(
            collect($response->json('data'))->firstWhere('iso2', 'NG')['id'],
            (new CountryResource(Country::whereIso2('NG')->first()))->resolve()['id']
        );

        $response = $this->get('/api/v1/countries?allowed=NG,GH', [
            'Referer' => 'https://naija-places.toneflix.com.ng/tests'
        ]);

        $response->assertOk();

        $this->assertSame(
            collect($response->json('data'))->firstWhere('iso2', 'GH')['id'],
            (new CountryResource(Country::whereIso2('GH')->first()))->resolve()['id']
        );

        $this->assertSame(
            collect($response->json('data'))->firstWhere('iso2', 'NG')['id'],
            (new CountryResource(Country::whereIso2('NG')->first()))->resolve()['id']
        );
    }

    public function testCanHideBannedStates(): void
    {
        $response = $this->get('/api/v1/countries/NG/states?banned=ab', [
            'Referer' => 'https://naija-places.toneflix.com.ng/tests'
        ]);

        $response->assertOk();

        $this->assertSame(
            collect($response->json('data'))->firstWhere('iso2', 'RI')['id'],
            (new StateResource(State::whereIso2('RI')->whereCountryCode('NG')->first()))->resolve()['id']
        );

        $this->assertNull(
            collect($response->json('data'))->firstWhere('iso2', 'AB'),
        );
    }

    public function testCanLoadOnlyAllowedStates(): void
    {
        $response = $this->get('/api/v1/countries/NG/states?allowed=ri', [
            'Referer' => 'https://naija-places.toneflix.com.ng/tests'
        ]);

        $response->assertOk();

        $this->assertSame(
            collect($response->json('data'))->firstWhere('iso2', 'RI')['id'],
            (new StateResource(State::whereIso2('RI')->whereCountryCode('NG')->first()))->resolve()['id']
        );

        $this->assertNull(
            collect($response->json('data'))->firstWhere('iso2', 'AB'),
        );
    }

    public function testCanHideBannedCities(): void
    {
        $response = $this->get('/api/v1/countries/NG/states/RI/cities?banned=148552', [
            'Referer' => 'https://naija-places.toneflix.com.ng/tests'
        ]);

        $response->assertOk();

        $this->assertSame(
            collect($response->json('data'))->firstWhere('id', '148553')['id'],
            (new CityResource(City::whereId('148553')->first()))->resolve()['id']
        );

        $this->assertNull(
            collect($response->json('data'))->firstWhere('id', '148552'),
        );
    }

    public function testCanLoadOnlyAllowedCities(): void
    {
        $response = $this->get('/api/v1/countries/NG/states/RI/cities?allowed=148553', [
            'Referer' => 'https://naija-places.toneflix.com.ng/tests'
        ]);

        $response->assertOk();

        $this->assertSame(
            collect($response->json('data'))->firstWhere('id', '148553')['id'],
            (new CityResource(City::whereId('148553')->whereCountryCode('NG')->first()))->resolve()['id']
        );

        $this->assertNull(
            collect($response->json('data'))->firstWhere('id', '148552'),
        );
    }
}
