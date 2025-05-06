<?php

namespace App\Http\Controllers;

use App\Http\Requests\StationStoreRequest;
use App\Http\Requests\StationUpdateRequest;
use App\Models\Station;
use App\Repositories\StationRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StationController extends Controller
{
    protected $stationRepository;
    public function __construct(StationRepository $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }

    public function index()
    {
        return view('station.index');
    }

    public function datatable(Request $request)
    {
        if($request->ajax()) {
            return $this->stationRepository->datatable($request);
        }
    }

    public function create() {
        return view('station.create');
    }

    public function store(StationStoreRequest $request) {
        try {
            $location = explode(',', $request->location);
            $this->stationRepository->create([
                'slug' => Str::slug($request->title) .'-'. Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'latitude' => $location[0],
                'longitude' => $location[1],
            ]);
            return redirect()->route('station.index')->with('success', 'Station created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function show($id)
    {
        $station = $this->stationRepository->find($id);
        return view('station.show', compact('station'));
    }

    public function edit($id) 
    {
        $station = $this->stationRepository->find($id);
        return view('station.edit', compact('station'));
    }

    public function update($id, StationUpdateRequest $request) {
        try {
            $location = explode(',', $request->location);
            $this->stationRepository->update($id, [
                'slug' => Str::slug($request->title) .'-'. Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'latitude' => $location[0],
                'longitude' => $location[1],
            ]);
            return redirect()->route('station.index')->with('success', 'Station updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id) {
        try {
            $this->stationRepository->delete($id);
            return ResponseService::success([], 'Station deleted successfully');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
