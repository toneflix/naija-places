<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = \App\Models\State::all();
        $all = collect(json_decode(File::get(database_path('data/states-and-lgas-and-wards-and-polling-units.json'))));
        $states->each(function ($state) use ($all) {
            $state->wards->each(function ($ward) use ($all, $state) {
                $units = collect(
                    collect($all->firstWhere('state', $state->slug)->lgas ?? [])
                        ->firstWhere('lga', $ward->lga->slug)?->wards ?? []
                )->firstWhere('ward', $ward->slug)?->polling_units ?? [];

                collect($units)->each(function ($slug) use ($state, $ward) {
                    \App\Models\Unit::unguard();
                    \App\Models\Unit::insert([
                        'slug' => str($slug)->slug('-'),
                        'name' => str($slug)->title()->replace('-', ' '),
                        'lga_id' => $ward->lga->id,
                        'ward_id' => $ward->id,
                        'state_id' => $state->id,
                        "created_at" => now(),
                        "updated_at" => now(),
                    ]);
                });
            });
        });
    }
}
