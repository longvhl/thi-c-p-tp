<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Basic Users
        User::updateOrCreate(
            ['email' => 'admin@bikego.com'],
            [
                'name' => 'Admin BikeGo',
                'phone' => '0999999999',
                'password' => Hash::make('12345'),
                'role' => 'admin'
            ]
        );

        User::factory()->create([
            'name' => 'Vũ Hoàng Long',
            'email' => 'long@example.com',
            'phone' => '0912345678',
            'password' => Hash::make('password'),
        ]);

        for ($i = 0; $i < 5; $i++) {
            User::create([
                'name' => 'Biker ' . ($i + 1),
                'email' => "biker{$i}@example.com",
                'phone' => '0' . rand(100000000, 999999999),
                'password' => Hash::make('password'),
            ]);
        }

        // 2. Load Wards from JSON
        $jsonPath = database_path('data/phuong.json');
        if (file_exists($jsonPath)) {
            $jsonData = json_decode(file_get_contents($jsonPath), true);
            if (isset($jsonData['communes'])) {
                foreach ($jsonData['communes'] as $c) {
                    \App\Models\Ward::updateOrCreate(
                        ['code' => $c['code']],
                        [
                            'name' => $c['name'],
                            'administrative_level' => $c['administrativeLevel'] ?? 'Phường',
                            'province_code' => $c['provinceCode'] ?? '79'
                        ]
                    );
                }
            }
        }

        // 3. Base Station Templates
        $stationsData = [
            ['name' => 'Bến Thành', 'code' => 's1', 'image' => '/assets/BenThanh.png'],
            ['name' => 'Thảo Điền', 'code' => 's2', 'image' => '/assets/ThaoDien.png'],
            ['name' => 'Sư Vạn Hạnh', 'code' => 's3', 'image' => '/assets/SuVanHanh.png'],
            ['name' => 'Landmark 81', 'code' => 's4', 'image' => '/assets/landmark81.png'],
            ['name' => 'Lê Văn Sỹ', 'code' => 's5', 'image' => '/assets/LeVanSy.png'],
        ];

        $bikeTypes = [
            'xe_thuong' => ['name' => 'Xe đạp cơ', 'price' => 200],
            'xe_dien' => ['name' => 'Xe đạp điện', 'price' => 500],
            'xe_troluc' => ['name' => 'Xe trợ lực', 'price' => 300],
        ];

        // 4. Distribute wards among stations and generate 10-20 bikes
        $allWards = \App\Models\Ward::all();
        $stDataCount = count($stationsData);
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Station::truncate();
        \App\Models\Bike::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($allWards as $index => $ward) {
            $baseData = $stationsData[$index % $stDataCount];
            
            $st = \App\Models\Station::create([
                'name' => $baseData['name'] . ' (' . $ward->name . ')',
                'code' => $baseData['code'] . '-' . $ward->code,
                'image_url' => $baseData['image'],
                'ward_id' => $ward->id,
                'status' => 'active'
            ]);

            // Generate 10-20 bikes
            $targetCount = rand(10, 20);
            for ($i = 1; $i <= $targetCount; $i++) {
                $type = array_rand($bikeTypes);
                $info = $bikeTypes[$type];
                
                \App\Models\Bike::create([
                    'bike_number' => strtoupper(substr($type, 3, 1)) . "-" . $st->id . "-" . $i,
                    'type' => $type,
                    'status' => (rand(1, 10) == 1) ? 'maintenance' : 'available',
                    'current_station' => $st->id,
                    'unit_price' => $info['price'],
                ]);
            }
        }

        // 5. Minimal Reviews for "Top Stations" or logic
        // Only if needed to make the UI look good. But user said "only what I told you".
    }
}
