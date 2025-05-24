<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Station;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Contracts\BaseRepository;

class StationRepository implements BaseRepository
{
    protected $model;
    public function __construct()
    {
        $this->model = Station::class;
    }
    public function find($id)
    {
        $record = $this->model::find($id);
        return $record;
    }
    public function create(array $data)
    {
        $record = $this->model::create($data);
        return $record;
    }
    public function update($id, array $data)
    {
        $record = $this->model::find($id);
        $record->update($data);
        return $record;
    }
    public function delete($id)
    {
        $record = $this->model::find($id);
        $record->delete();
        return $record;  
    }
    public function datatable(Request $request)
    {
        $model = $this->model::query();
        return DataTables::eloquent($model)
            ->editColumn('description', function($station){
                return Str::limit($station->description, 50, ' ...');
            })
            ->editColumn('created_at', function($station){
                return Carbon::parse($station->created_at)->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function($station){
                return Carbon::parse($station->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function($station){
                return view('station._action', compact('station'));
            })
            ->addColumn('responsive-icon', function($station){
                return null;
            })
            ->toJson();
    }

    // frontend api
    public function query()
    {
        return $this->model::query();
    }
    public function queryBySlug($slug)
    {
        return $this->model::where('slug', $slug);
    }
}