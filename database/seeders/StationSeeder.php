<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Repositories\StationRepository;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stations = json_decode(file_get_contents(base_path('public/json/station.json')));
        foreach ($stations as $station) {
            (new StationRepository())->create([
                'slug' => Str::slug($station->title).'-'.Str::random(6),
                'title' => $station->title,
                'description' => $station->description,
                'longitude' => $station->longitude,
                'latitude' => $station->latitude,
            ]);
        }
    }
}
