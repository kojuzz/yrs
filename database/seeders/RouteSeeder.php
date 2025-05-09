<?php

namespace Database\Seeders;

use App\Repositories\RouteRepository;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Repositories\StationRepository;
use Carbon\Carbon;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $route_items = json_decode(file_get_contents(base_path('public/json/route.json')));
        foreach ($route_items as $route_item) {

            $schedule = [];
            $time = $route_item->departure_time;
            foreach($route_item->station_ids as $station_id) {
                $schedule[$station_id] = [
                    'time' => $time,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $time = Carbon::parse($time)->addMinutes(5)->format('H:i:s');
            }

            $route = (new RouteRepository())->create([
                'slug' => Str::slug($route_item->title) .'-'. Str::random(6),
                'title' => $route_item->title,
                'description' => $route_item->description,
                'direction' => $route_item->direction,
            ]);

            $route->stations()->sync($schedule);
        }
    }
}
