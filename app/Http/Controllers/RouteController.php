<?php

namespace App\Http\Controllers;

use App\Http\Requests\RouteStoreRequest;
use App\Http\Requests\RouteUpdateRequest;
use App\Repositories\RouteRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RouteController extends Controller
{
    protected $routeRepository;
    public function __construct(RouteRepository $routeRepository)
    {
        $this->routeRepository = $routeRepository;
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
        try {
            $location = explode(',', $request->location);
            $this->routeRepository->create([
                'slug' => Str::slug($request->title) .'-'. Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'latitude' => $location[0],
                'longitude' => $location[1],
            ]);
            return redirect()->route('route.index')->with('success', 'Route created successfully');
        } catch (\Exception $e) {
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
