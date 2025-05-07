<?php

namespace App\Http\Controllers;

use App\Http\Requests\RouteStoreRequest;
use App\Http\Requests\RouteUpdateRequest;
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
        return view('route.create');
    }

    public function store(RouteStoreRequest $request) {
        DB::beginTransaction();
        try {
            $route = $this->routeRepository->create([
                'slug' => Str::slug($request->title) .'-'. Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'direction' => $request->direction,
            ]);

            foreach($request->schedule as $item) {
                $this->routeStationRepository->create([
                    'route_id' => $route->id,
                    'station_id' => $item['station_id'],
                    'time' => $item['time'],
                ]);
            }
            
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
        $route = $this->routeRepository->find($id);
        return view('route.edit', compact('route'));
    }

    public function update($id, RouteUpdateRequest $request) {
        try {
            $location = explode(',', $request->location);
            $this->routeRepository->update($id, [
                'slug' => Str::slug($request->title) .'-'. Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'latitude' => $location[0],
                'longitude' => $location[1],
            ]);
            return redirect()->route('route.index')->with('success', 'Route updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id) {
        try {
            $this->routeRepository->delete($id);
            return ResponseService::success([], 'Route deleted successfully');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
