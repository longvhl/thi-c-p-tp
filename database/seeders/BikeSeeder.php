<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bike;
use App\Models\Station;

class BikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stations = Station::pluck('id')->toArray();
        if (empty($stations)) return;

        $bikes = [
            ['bike_number' => '01_100', 'type' => 'xe_thuong', 'status' => 'available', 'unit_price' => 500, 'current_station' => $stations[0]],
            ['bike_number' => '02_100', 'type' => 'xe_thuong', 'status' => 'available', 'unit_price' => 1000, 'current_station' => $stations[0]],
            ['bike_number' => '03_100', 'type' => 'xe_thuong', 'status' => 'available', 'unit_price' => 1500, 'current_station' => $stations[0]],
            ['bike_number' => '01_101', 'type' => 'xe_dien', 'status' => 'available', 'unit_price' => 500, 'current_station' => $stations[1] ?? $stations[0]],
            ['bike_number' => '02_101', 'type' => 'xe_dien', 'status' => 'available', 'unit_price' => 1000, 'current_station' => $stations[1] ?? $stations[0]],
            ['bike_number' => '03_101', 'type' => 'xe_dien', 'status' => 'available', 'unit_price' => 1500, 'current_station' => $stations[1] ?? $stations[0]],
            ['bike_number' => '01_102', 'type' => 'xe_troluc', 'status' => 'available', 'unit_price' => 500, 'current_station' => $stations[2] ?? $stations[0]],
            ['bike_number' => '02_102', 'type' => 'xe_troluc', 'status' => 'available', 'unit_price' => 1000, 'current_station' => $stations[2] ?? $stations[0]],
            ['bike_number' => '03_102', 'type' => 'xe_troluc', 'status' => 'available', 'unit_price' => 1500, 'current_station' => $stations[2] ?? $stations[0]],
        ];

        foreach ($bikes as $data) {
            Bike::updateOrCreate(['bike_number' => $data['bike_number']], $data);
        }
    }
}
