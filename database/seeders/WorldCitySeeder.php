<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class WorldCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('memory_limit', '512M');

        // Path to your SQL file
        $path = database_path('data/cities.sql');

        // Check if the file exists
        if (File::exists($path)) {
            // Get the contents of the SQL file
            $sql = str(File::get($path))->replace(["\'", '\"'], ["''", '"'])->toString();

            // try {
            // Execute the SQL
            DB::unprepared($sql);
            // } catch (\Throwable $th) {
            // $this->command->error('Error occured: ' . $th->getMessage());
            // return;
            // }

            $this->command->info('SQL file seeded successfully!');
        } else {
            $this->command->error('SQL file not found.');
        }
    }
}
