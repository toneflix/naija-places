<?php

namespace Database\Seeders;

use App\Models\Log;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $time = now()->subDays(rand(2, 10));

        Log::factory(rand(5, 10))->create();
        Log::factory(4, [
            'created_at' => $time,
            'updated_at' => $time->addHours(10),
        ])->create();
    }
}