<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $ignoreAdmin = collect(request(null)->server('argv'))->contains(fn($key) => str($key)->contains('phpunit'));

        $adminEmail = 'admin@example.com';

        if (!$ignoreAdmin) {
            if (app()->runningInConsole()) {
                $adminEmail = $this->command->ask('Enter admin email address', $adminEmail);
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
            StateSeeder::class,
            LgaSeeder::class,
            WardSeeder::class,
            CitySeeder::class,
            UnitSeeder::class,
        ]);
    }
}
