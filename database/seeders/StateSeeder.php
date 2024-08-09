<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $all = collect(json_decode(File::get(database_path('data/nigerian_states.json'))));
        $all->each(function ($data) {
            \App\Models\State::unguard();
            \App\Models\State::insert([
                'slug' => str($data->name)->slug('-'),
                'code' => $data->code,
                'name' => str($data->name)->slug()->is('abuja') ? 'Federal Capital Territory (Abuja)' : $data->name,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        });
    }
}
