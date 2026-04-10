<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Station;
use App\Models\Ward;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wards = Ward::pluck('id')->toArray();
        if (empty($wards)) return;

        $stations = [
           
        ];

        foreach ($stations as $data) {
            Station::updateOrCreate(['code' => $data['code']], $data);
        }
    }
}
