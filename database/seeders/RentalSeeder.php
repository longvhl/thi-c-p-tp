<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rental;
use App\Models\User;
use App\Models\Bike;
use App\Models\Station;
use Carbon\Carbon;

class RentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::pluck('id')->toArray();
        $bikes = Bike::where('status', 'available')->get();
        $stations = Station::pluck('name')->toArray();

        if (count($users) < 3 || $bikes->count() < 2 || empty($stations)) return;

        $rentals = [
            [
                'user_id' => $users[1],
                'bike_number' => $bikes[0]->bike_number,
                'bike_type' => 'Xe đạp cơ',
                'station_start' => $stations[0],
                'start_time' => Carbon::now()->subMinutes(30),
                'status' => 'active',
                'unit_price' => $bikes[0]->unit_price
            ],
            [
                'user_id' => $users[2],
                'bike_number' => $bikes[1]->bike_number,
                'bike_type' => 'Xe đạp điện',
                'station_start' => $stations[1] ?? $stations[0],
                'start_time' => Carbon::now()->subMinutes(15),
                'status' => 'active',
                'unit_price' => $bikes[1]->unit_price
            ],
        ];

        foreach ($rentals as $data) {
            Rental::create($data);
        }
        
        // Mark bikes as rented
        Bike::whereIn('bike_number', [$bikes[0]->bike_number, $bikes[1]->bike_number])->update(['status' => 'rented']);
    }
}
