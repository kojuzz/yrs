<?php

namespace App\Repositories;

use App\Models\TicketInspector;
use App\Repositories\Contracts\BaseRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TicketInspectorRepository implements BaseRepository
{
    protected $model;
    public function __construct()
    {
        $this->model = TicketInspector::class;
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
        $model = TicketInspector::query();
        return DataTables::eloquent($model)
            ->editColumn('email_verified_at', function ($ticket_inspector) {
                return $ticket_inspector->email_verified_at ? Carbon::parse($ticket_inspector->email_verified_at)->format('Y-m-d H:i:s') : 'Not verified';
            })
            ->editColumn('created_at', function($ticket_inspector){
                return Carbon::parse($ticket_inspector->created_at)->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function($ticket_inspector){
                return Carbon::parse($ticket_inspector->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function($ticket_inspector){
                return view('ticket-inspector._action', compact('ticket_inspector'));
            })
            ->addColumn('responsive-icon', function($ticket_inspector){
                return null;
            })
            ->toJson();
    }
}