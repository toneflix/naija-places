<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = \App\Models\State::all();
        $all = collect(json_decode(File::get(database_path('data/states-and-lgas-and-wards.json'))));
        $states->each(function ($state) use ($all) {
            $state->lgas->each(function ($lga) use ($all, $state) {
                $wards = collect(
                    collect($all->firstWhere('state', $state->slug)->lgas ?? [])->firstWhere('lga', $lga->slug)?->wards ?? []
                );

                $wards->each(function ($slug) use ($state, $lga) {
                    \App\Models\Ward::unguard();
                    \App\Models\Ward::insert([
                        'slug' => str($slug)->slug('-'),
                        'name' => str($slug)->title()->replace('-', ' '),
                        'lga_id' => $lga->id,
                        'state_id' => $state->id,
                        "created_at" => now(),
                        "updated_at" => now(),
                    ]);
                });
            });
        });
    }
}