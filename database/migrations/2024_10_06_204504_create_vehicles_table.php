<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. VehicleCountry Migration
        Schema::create('vehicle_countries', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('name'); // renamed from country_name to name
            $table->timestamps();
        });

        // 2. VehicleYear Migration
        Schema::create('vehicle_years', function (Blueprint $table) {
            $table->id(); // primary key
            $table->year('year_from');
            $table->year('year_to')->nullable();
            $table->timestamps();
        });

        // 3. VehicleManufacturer Migration
        Schema::create('vehicle_manufacturers', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('name'); // renamed from manufacturer_name to name
            $table->timestamps();
        });

        // 4. VehicleDerivative (Trim) Migration
        Schema::create('vehicle_derivatives', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('name');  // renamed from trim_name to name, e.g. "3.5 MT"
            $table->timestamps();
        });

        // 5. VehicleModel Migration
        Schema::create('vehicle_models', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('name'); // renamed from model_name to name
            $table->string('generation')->nullable(); // e.g. "1 generation"
            $table->foreignId('manufacturer_id')->constrained('vehicle_manufacturers'); // foreign key to vehicle manufacturers
            $table->timestamps();
        });

        // 6. Vehicle Migration (core details)
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id(); // primary key
            $table->foreignId('model_id')->constrained('vehicle_models');  // foreign key to vehicle model
            $table->foreignId('year_id')->constrained('vehicle_years');    // foreign key to vehicle year
            $table->foreignId('country_id')->constrained('vehicle_countries'); // foreign key to country of origin
            $table->foreignId('derivative_id')->constrained('vehicle_derivatives');  // foreign key to derivative (trim)
            $table->integer('number_of_doors')->nullable();
            $table->string('car_class')->nullable();
            $table->timestamps();
        });

        // 7. VehicleBody Migration (physical dimensions)
        Schema::create('vehicle_bodies', function (Blueprint $table) {
            $table->id(); // primary key
            $table->foreignId('vehicle_id')->constrained('vehicles');  // foreign key to vehicle
            $table->string('body_type')->nullable();   // e.g. "Coupe"
            $table->integer('length_mm')->nullable();
            $table->integer('width_mm')->nullable();
            $table->integer('height_mm')->nullable();
            $table->integer('wheelbase_mm')->nullable();
            $table->integer('curb_weight_kg')->nullable();
            $table->integer('number_of_seats')->nullable();
            $table->timestamps();
        });

        // 8. VehicleEngine Migration
        Schema::create('vehicle_engines', function (Blueprint $table) {
            $table->id(); // primary key
            $table->foreignId('vehicle_id')->constrained('vehicles');  // foreign key to vehicle
            $table->string('engine_type')->nullable();      // e.g. "Gasoline"
            $table->integer('engine_hp')->nullable();       // Horsepower
            $table->integer('engine_hp_rpm')->nullable();   // RPM of the horsepower
            $table->integer('capacity_cm3')->nullable();    // Engine capacity
            $table->integer('number_of_cylinders')->nullable();
            $table->string('cylinder_layout')->nullable();  // e.g. "V-type"
            $table->string('injection_type')->nullable();   // e.g. "Injector"
            $table->integer('max_torque_n_m')->nullable();  // Torque in Nm
            $table->timestamps();
        });

        // 9. VehicleMileage Migration
        Schema::create('vehicle_mileages', function (Blueprint $table) {
            $table->id(); // primary key
            $table->foreignId('vehicle_id')->constrained('vehicles');  // foreign key to vehicle
            $table->decimal('city_fuel_per_100km_l', 8, 2)->nullable();  // City fuel consumption (L/100km)
            $table->decimal('highway_fuel_per_100km_l', 8, 2)->nullable(); // Highway fuel consumption (L/100km)
            $table->decimal('mixed_fuel_consumption_per_100_km_l', 8, 2)->nullable(); // Mixed fuel consumption
            $table->integer('range_km')->nullable();          // Range in km
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_engines');
        Schema::dropIfExists('vehicle_bodies');
        Schema::dropIfExists('vehicle_models');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('vehicle_derivatives');
        Schema::dropIfExists('vehicle_mileages');
        Schema::dropIfExists('vehicle_years');
        Schema::dropIfExists('vehicle_countries');
        Schema::dropIfExists('vehicle_manufacturers');
    }
};
