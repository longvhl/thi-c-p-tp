<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Bike;
use App\Models\Station;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        if (!$user) return;

        $bikes = Bike::all();
        $stations = Station::all();

        $reviews = [
            ['bike_id' => $bikes->get(0)?->id, 'station_id' => $stations->get(0)?->code ?? 's1', 'rating' => 5, 'comment' => 'Dịch vụ rất tốt!', 'user_id' => $user->id],
            ['bike_id' => $bikes->get(1)?->id, 'station_id' => $stations->get(1)?->code ?? 's2', 'rating' => 4, 'comment' => 'Xe mới, nhân viên nhiệt tình.', 'user_id' => $user->id],
            ['bike_id' => null, 'station_id' => $stations->get(0)?->code ?? 's1', 'rating' => 5, 'comment' => 'Trạm rất sạch sẽ.', 'user_id' => $user->id],
        ];

        foreach ($reviews as $data) {
            DB::table('reviews')->insert(array_merge($data, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
