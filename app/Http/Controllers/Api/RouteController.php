<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RouteDetailResource;
use App\Http\Resources\RouteResource;
use App\Models\RouteStation;
use App\Models\Station;
use App\Repositories\RouteRepository;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    protected $routeRepository;
    public function __construct(RouteRepository $routeRepository)
    {
        $this->routeRepository = $routeRepository;
    }
    public function index(Request $request)
    {
        $routes = $this->routeRepository->query()
            ->with(['stations'])
            ->when($request->has('search'), function ($q1) use ($request) {
                $q1->where('title', 'like', '%' . $request->search . '%');
            })
            ->when($request->origin_station_slug && $request->destination_station_slug, function ($q1) use ($request) {
                $origin_station = Station::where('slug', $request->origin_station_slug)->first();
                $destination_station = Station::where('slug', $request->destination_station_slug)->first();
                $route_ids = RouteStation::select('rs1.route_id')
                    ->from('route_stations as rs1')
                    ->join('route_stations as rs2', function($join) use ($destination_station) {
                        $join->on('rs1.route_id', '=', 'rs2.route_id')->where('rs2.station_id', $destination_station->id);
                    }) 
                    ->where('rs1.station_id', $origin_station->id)
                    ->whereRaw('rs1.time < rs2.time')
                    ->orderBy('rs1.time')
                    ->pluck('rs1.route_id')
                    ->toArray();
                $q1->whereIn('id', $route_ids);
            })
            ->paginate(10);
        return RouteResource::collection($routes)->additional(['message' => 'success']);
    }
    public function show($slug)
    {
        $route = $this->routeRepository->queryBySlug($slug)
            ->with(['stations'])
            ->firstOrFail();
        return ResponseService::success(new RouteDetailResource($route));
    }
}
