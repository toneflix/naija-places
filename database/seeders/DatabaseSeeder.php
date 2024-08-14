<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Lga;
use App\Models\State;
use App\Models\Unit;
use App\Models\User;
use App\Models\Ward;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $ignoreAdmin = collect(request(null)->server('argv'))->contains(fn($key) => str($key)->contains('phpunit'));

        $adminEmail = env('CI_ADMIN_EMAIL', 'admin@example.com');

        if (!File::exists(database_path('database.sqlite')) && config('database.default') === 'sqlite') {
            File::put(database_path('database.sqlite'), '');
            \Artisan::call('migrate');
        }

        if (app()->runningInConsole()) {
            if (!$ignoreAdmin && !env('CI_ADMIN_EMAIL')) {
                $adminEmail = $this->command->ask('Enter admin email address', $adminEmail);
            }

            if (!env('CI_TRUNCATE_TABLES')) {
                $truncate = $this->command->choice('Truncate database', ['Yes', 'No'], 'No');
                if ($truncate === 'Yes') {
                    State::truncate();
                    Lga::truncate();
                    Ward::truncate();
                    City::truncate();
                    Unit::truncate();
                }
            }
        }

        if (User::whereEmail($adminEmail)->doesntExist()) {
            User::factory()->create([
                'firstname' => 'Super',
                'lastname' => 'Admin',
                'email' => $adminEmail,
            ]);
        }

        $this->call([
            ConfigurationSeeder::class,
            StateSeeder::class,
            LgaSeeder::class,
            WardSeeder::class,
            CitySeeder::class,
            UnitSeeder::class,
        ]);
    }
}