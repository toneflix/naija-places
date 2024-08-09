<?php

namespace Database\Seeders;

use App\Models\Lga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class LgaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lga::truncate();
        $states = \App\Models\State::all();
        $lgas = collect(json_decode(File::get(database_path('data/lga_short_codes.json'))));
        $all = collect(json_decode(File::get(database_path('data/states-and-lgas.json'))));
        $states->each(function ($state) use ($all, $lgas) {
            if ($state->slug === 'fct') {
                $state->slug = 'abuja';
            }

            collect($all->firstWhere('state', $state->slug)->lgas)->each(function ($slug) use ($state, $lgas) {
                $data = $lgas->firstWhere(
                    fn($key) => str($key->name)->slug('-', 'en', ['/' => '-', '&' => '-'])->is($slug) ||
                        str($key->name)->camel()->lower()->is($slug)
                );

                if ($data) {
                    \App\Models\Lga::unguard();
                    \App\Models\Lga::insert([
                        'slug' => str($data->name)->slug('-'),
                        'code' => $data->code,
                        'name' => $data->name,
                        'state_id' => $state->id,
                        "created_at" => now(),
                        "updated_at" => now(),
                    ]);
                }
            });
        });
    }
}