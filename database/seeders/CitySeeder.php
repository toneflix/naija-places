<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = \App\Models\State::all();
        $all = collect(json_decode(File::get(database_path('data/states-and-towns.json'))));
        $states->each(function ($state) use ($all) {
            $towns = collect($all->firstWhere('state', $state->slug)->towns ?? []);

            $towns->each(function ($name) use ($state) {

                \App\Models\City::unguard();
                \App\Models\City::insert([
                    'slug' => str($name)->slug('-'),
                    'name' => str($name)->title()->replace('-', ' '),
                    'state_id' => $state->id,
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);
            });
        });
    }
}