<?php

namespace App\Repositories;

use App\Models\TopUpHistory;
use App\Models\WalletTransaction;
use App\Repositories\Contracts\BaseRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TopUpHistoryRepository implements BaseRepository
{
    protected $model;
    public function __construct()
    {
        $this->model = TopUpHistory::class;
    }
    public function find($id)
    {
        $record = $this->model::with(['user:id,name,email'])->find($id);
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
    public function delete($id) {}
    public function datatable(Request $request)
    {
        $model = TopUpHistory::with('user:id,name,email');
        return DataTables::eloquent($model)
            ->filterColumn('user_name', function ($query, $keyword) {
                $query->whereHas('user', function ($q1) use ($keyword) {
                    $q1->where('name', 'like', "%{$keyword}%")->orWhere('email', 'like', "%{$keyword}%");
                });
            })
            ->addColumn('user_name', function ($top_up_history) {
                return ($top_up_history->user->name ?? '-'). ' (' . ($top_up_history->user->email ?? '-'). ')';
            })
            ->editColumn('amount', function ($top_up_history) {
                return number_format($top_up_history->amount);
            })
            ->editColumn('status', function ($top_up_history) {
                return '<span style="color: #' . $top_up_history->acsrStatus['color'] . '">' . $top_up_history->acsrStatus['text'] . '</span>';
            })
            ->editColumn('created_at', function($top_up_history){
                return Carbon::parse($top_up_history->created_at)->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function($top_up_history){
                return Carbon::parse($top_up_history->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function($top_up_history){
                return view('top-up-history._action', compact('top_up_history'));
            })
            ->addColumn('responsive-icon', function($top_up_history){
                return null;
            })
            ->rawColumns(['status'])
            ->toJson();
    }
}