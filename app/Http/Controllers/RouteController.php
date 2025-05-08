<?php

namespace App\Http\Controllers;

use App\Http\Requests\RouteStoreRequest;
use App\Http\Requests\RouteUpdateRequest;
use App\Models\Route;
use App\Models\RouteStation;
use App\Models\Station;
use App\Repositories\RouteRepository;
use App\Repositories\RouteStationRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RouteController extends Controller
{
    protected $routeRepository;
    protected $routeStationRepository;
    public function __construct(RouteRepository $routeRepository, RouteStationRepository $routeStationRepository)
    {
        $this->routeRepository = $routeRepository;
        $this->routeStationRepository = $routeStationRepository;
    }

    public function index()
    {
        return view('route.index');
    }

    public function datatable(Request $request)
    {
        if($request->ajax()) {
            return $this->routeRepository->datatable($request);
        }
    }

    public function create() {
        $selected_stations = Station::whereIn('id', collect(old('schedule'))->pluck('station_id')->toArray())->get(['id', 'title']);
        $schedule = collect(old('schedule'))->map(function($item) use ($selected_stations) {
            return [
                'station_id' => $item['station_id'],
                'station_title' => collect($selected_stations)->where('id', $item['station_id'])->first()->title ?? '-', 
                'time' => $item['time']
            ];
        });
        return view('route.create', compact('schedule'));
    }

    public function store(RouteStoreRequest $request) {

        // $schedule = collect($request->schedule)->mapWithKeys(function($item) {
        //     return [$item['station_id'] => ['time' => $item['time'], 'created_at' => now(), 'updated_at' => now()]];
        // });
        // return $schedule;
        DB::beginTransaction();
        try {
            throw new Exception("Hello");
            $route = $this->routeRepository->create([
                'slug' => Str::slug($request->title) .'-'. Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'direction' => $request->direction,
            ]);

            $schedule = collect($request->schedule)->mapWithKeys(function($item) {
                return [$item['station_id'] => ['time' => $item['time'], 'created_at' => now(), 'updated_at' => now()]];
            });
            $route->stations()->sync($schedule);

            // foreach($request->schedule as $item) {
            //     $this->routeStationRepository->create([
            //         'route_id' => $route->id,
            //         'station_id' => $item['station_id'],
            //         'time' => $item['time'],
            //     ]);
            // }
            
            DB::commit();
            return redirect()->route('route.index')->with('success', 'Route created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function show($id)
    {
        $route = $this->routeRepository->find($id);
        return view('route.show', compact('route'));
    }

    public function edit($id) 
    {
        // $route = $this->routeRepository->find($id);
        $route = Route::find($id);
        $route_stations = RouteStation::where('route_id', $route->id)->get(['station_id', 'time']);
        $selected_stations = Station::whereIn('id', collect(old('schedule', $route_stations))->pluck('station_id')->toArray())->get(['id', 'title']);
        $schedule = collect(old('schedule', $route_stations))->map(function($item) use ($selected_stations) {
            return [
                'station_id' => $item['station_id'],
                'station_title' => collect($selected_stations)->where('id', $item['station_id'])->first()->title ?? '-', 
                'time' => $item['time']
            ];
        });
        // return $schedule;
        return view('route.edit', compact('route', 'schedule'));
    }

    public function update($id, RouteUpdateRequest $request) {
        DB::beginTransaction();
        try {
            $route = $this->routeRepository->update($id, [
                'slug' => Str::slug($request->title) .'-'. Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'direction' => $request->direction,
            ]);

            $schedule = collect($request->schedule)->mapWithKeys(function($item) {
                return [$item['station_id'] => ['time' => $item['time'], 'created_at' => now(), 'updated_at' => now()]];
            });
            $route->stations()->sync($schedule);
            
            DB::commit();
            return redirect()->route('route.index')->with('success', 'Route updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id) {
        DB::beginTransaction();
        try {
            // Delete Route
            $this->routeRepository->delete($id);
            // Delete RouteStation
            $this->routeStationRepository->deleteByRouteId($id);
            DB::commit();
            return ResponseService::success([], 'Route deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }
}
