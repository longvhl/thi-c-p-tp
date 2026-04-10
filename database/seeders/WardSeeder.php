<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $url = "https://production.cas.so/address-kit/2025-07-01/provinces/79/communes";
        try {
            $response = \Illuminate\Support\Facades\Http::get($url);
            if ($response->successful()) {
                $communes = $response->json()['communes'] ?? [];
                foreach ($communes as $c) {
                    \App\Models\Ward::updateOrCreate(
                        ['code' => $c['code']],
                        [
                            'name' => $c['name'],
                            'administrative_level' => $c['administrativeLevel'],
                            'province_code' => $c['provinceCode']
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            $this->command->error("Failed to fetch ward data: " . $e->getMessage());
        }

        // Map existing stations to wards based on name matching
        $allWards = \App\Models\Ward::all();
        foreach (\App\Models\Station::all() as $st) {
            $matchingWard = $allWards->first(function($w) use ($st) {
                // Remove prefixes like "Phường ", "Xã " for better matching if needed
                $wName = str_replace(['Phường ', 'Xã '], '', $w->name);
                return str_contains($st->name, $wName) || str_contains($wName, $st->name);
            });
            if ($matchingWard) {
                $st->update(['ward_id' => $matchingWard->id]);
            }
        }
    }
}
