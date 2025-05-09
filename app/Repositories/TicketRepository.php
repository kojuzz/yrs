<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Contracts\BaseRepository;

class TicketRepository implements BaseRepository
{
    protected $model;
    public function __construct()
    {
        $this->model = Ticket::class;
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
            $model = $this->model::with(['user:id,name,email']);
            return DataTables::eloquent($model)
                ->filterColumn('user_name', function ($query, $keyword) {
                    $query->whereHas('user', function ($q1) use ($keyword) {
                        $q1->where('name', 'like', "%{$keyword}%")->orWhere('email', 'like', "%{$keyword}%");
                    });
                })
                ->addColumn('user_name', function($ticket){
                    return $ticket->user ? ($ticket->user->name. ' ('.$ticket->user->email.')') : '-';
                })
                ->editColumn('price', function($ticket){
                    return number_format($ticket->price);
                })
                ->editColumn('type', function ($ticket) {
                    return '<span style="color: #' . $ticket->acsrType['color'] . '">' . $ticket->acsrType['text'] . '</span>';
                })
                ->editColumn('direction', function ($ticket) {
                    return '<span style="color: #' . $ticket->acsrDirection['color'] . '">' . $ticket->acsrDirection['text'] . '</span>';
                })
                ->editColumn('created_at', function($ticket){
                    return Carbon::parse($ticket->created_at)->format('Y-m-d H:i:s');
                })
                ->editColumn('updated_at', function($ticket){
                    return Carbon::parse($ticket->updated_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('responsive-icon', function($ticket){
                    return null;
                })
                ->addColumn('action', function($ticket){
                    return view('ticket._action', compact('ticket'));
                })
                ->rawColumns(['type', 'direction'])
                ->toJson();
        }
}