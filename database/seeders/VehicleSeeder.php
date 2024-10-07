<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\Csv\Reader;
use App\Models\Vehicles\VehicleCountry;
use App\Models\Vehicles\VehicleYear;
use App\Models\Vehicles\VehicleManufacturer;
use App\Models\Vehicles\VehicleDerivative;
use App\Models\Vehicles\VehicleModel;
use App\Models\Vehicles\Vehicle;
use App\Models\Vehicles\VehicleBody;
use App\Models\Vehicles\VehicleEngine;
use App\Models\Vehicles\VehicleMileage;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('memory_limit', '1024M');

        $csv = Reader::createFromPath(database_path('data/car-dataset-1945-2020.csv'), 'r');
        $csv->setHeaderOffset(0);
        foreach ($csv as $vehicleData) {
            // Step 1: Insert Manufacturer
            $manufacturer = VehicleManufacturer::firstOrCreate(['name' => $vehicleData['Make']]);

            // Step 2: Insert VehicleModel
            $model = VehicleModel::firstOrCreate([
                'name' => $vehicleData['Modle'],
                'generation' => $vehicleData['Generation'],
                'manufacturer_id' => $manufacturer->id
            ]);

            // Step 3: Insert VehicleYear
            $year = VehicleYear::firstOrCreate([
                'year_from' => $vehicleData['Year_from'],
                'year_to' => $vehicleData['Year_to']
            ]);

            // Step 4: Insert VehicleDerivative (Trim)
            $trim = VehicleDerivative::firstOrCreate([
                'name' => $vehicleData['Trim']
            ]);

            // Step 5: Insert VehicleCountry (We’ll assume country data is provided)
            $country = VehicleCountry::firstOrCreate([
                'name' => $vehicleData['country_of_origin'] ?: "Unknown"
            ]);

            // Step 6: Insert Vehicle
            $vehicle = Vehicle::create([
                'model_id' => $model->id,
                'year_id' => $year->id,
                'country_id' => $country->id,
                'derivative_id' => $trim->id,
                'number_of_doors' => $vehicleData['number_of_doors'] ?? null,
                'car_class' => $vehicleData['Series'] ?? null
            ]);

            // Step 7: Insert VehicleBody
            VehicleBody::create([
                'vehicle_id' => $vehicle->id,
                'body_type' => $vehicleData['Body_type'],
                'length_mm' => $vehicleData['length_mm'],
                'width_mm' => $vehicleData['width_mm'],
                'height_mm' => $vehicleData['height_mm'],
                'curb_weight_kg' => $vehicleData['curb_weight_kg'],
                'number_of_seats' => $vehicleData['number_of_seats']
            ]);

            // Step 8: Insert VehicleEngine
            VehicleEngine::create([
                'vehicle_id' => $vehicle->id,
                'engine_type' => $vehicleData['engine_type'],
                'engine_hp' => $vehicleData['engine_hp'],
                'engine_hp_rpm' => $vehicleData['engine_hp_rpm'],
                'capacity_cm3' => $vehicleData['capacity_cm3'],
                'number_of_cylinders' => $vehicleData['number_of_cylinders'],
                'cylinder_layout' => $vehicleData['cylinder_layout'],
                'injection_type' => $vehicleData['injection_type'],
                'max_torque_n_m' => $vehicleData['maximum_torque_n_m']
            ]);

            // Step 9: Insert VehicleMileage
            VehicleMileage::create([
                'vehicle_id' => $vehicle->id,
                'city_fuel_per_100km_l' => $vehicleData['city_fuel_per_100km_l'],
                'highway_fuel_per_100km_l' => $vehicleData['highway_fuel_per_100km_l'],
                'mixed_fuel_consumption_per_100_km_l' => $vehicleData['mixed_fuel_consumption_per_100_km_l'],
                'range_km' => $vehicleData['range_km']
            ]);
        }
    }
}
