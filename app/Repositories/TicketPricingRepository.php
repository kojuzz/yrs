<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\TicketPricing;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Contracts\BaseRepository;

class TicketPricingRepository implements BaseRepository
{
    protected $model;
    public function __construct()
    {
        $this->model = TicketPricing::class;
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
            ->editColumn('type', function ($ticket_pricing) {
                return '<span style="color: #' . $ticket_pricing->acsrType['color'] . '">' . $ticket_pricing->acsrType['text'] . '</span>';
            })
            ->editColumn('price', function ($ticket_pricing) {
                return number_format($ticket_pricing->price);
            })
            ->editColumn('offer_quantity', function ($ticket_pricing) {
                return number_format($ticket_pricing->offer_quantity);
            })
            ->editColumn('remain_quantity', function ($ticket_pricing) {
                return number_format($ticket_pricing->remain_quantity);
            })
            ->editColumn('started_at', function($ticket_pricing){
                return Carbon::parse($ticket_pricing->started_at)->format('Y-m-d H:i:s');
            })
            ->editColumn('ended_at', function($ticket_pricing){
                return Carbon::parse($ticket_pricing->ended_at)->format('Y-m-d H:i:s');
            })
            ->editColumn('created_at', function($ticket_pricing){
                return Carbon::parse($ticket_pricing->created_at)->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function($ticket_pricing){
                return Carbon::parse($ticket_pricing->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function($ticket_pricing){
                return view('ticket-pricing._action', compact('ticket_pricing'));
            })
            ->addColumn('responsive-icon', function($ticket_pricing){
                return null;
            })
            ->rawColumns(['type'])
            ->toJson();
    }
}