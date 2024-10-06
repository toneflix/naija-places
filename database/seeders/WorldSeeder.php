<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            RegionSeeder::class,
            SubRegionSeeder::class,
            CountrySeeder::class,
            WorldStateSeeder::class,
            WorldCitySeeder::class,
        ]);
    }
}
