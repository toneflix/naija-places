<?php

namespace Database\Factories;

use App\Models\ApiKey;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $routeCollection = \Illuminate\Support\Facades\Route::getRoutes();
        $uri = collect($routeCollection->getRoutes())
            ->shuffle()
            ->filter(fn($r) => str($r->uri())->contains('countries'))
            ->first();

        return [
            'origin' => $this->faker->url(),
            'endpoint' => route($uri->getName(), collect($uri->parameterNames())->mapWithKeys(fn($n) => [$n => rand()])),
            'ip_address' => $this->faker->ipv4(),
            'api_key_id' => ApiKey::inRandomOrder()->first('id')?->id,
        ];
    }
}