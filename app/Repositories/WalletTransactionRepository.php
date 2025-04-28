<?php

namespace App\Repositories;

use App\Models\WalletTransaction;
use App\Repositories\Contracts\BaseRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WalletTransactionRepository implements BaseRepository
{
    protected $model;
    public function __construct()
    {
        $this->model = WalletTransaction::class;
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
    public function update($id, array $data) {}
    public function delete($id) {}
    public function datatable(Request $request)
    {
        $model = WalletTransaction::with('user:id,name,email');
        return DataTables::eloquent($model)
            ->addColumn('user_name', function ($wallet) {
                return ($wallet->user->name ?? '-'). ' (' . ($wallet->user->email ?? '-'). ')';
            })
            ->editColumn('method', function ($wallet) {
                // return $wallet->acsrMethod['text'];
                // return '<span class="tw-text-[#' . $wallet->acsrMethod['color'] . ']">' . $wallet->acsrMethod['text'] . '</span>';
                return '<span style="color: #' . $wallet->acsrMethod['color'] . '">' . $wallet->acsrMethod['text'] . '</span>';
            })
            ->editColumn('type', function ($wallet) {
                return '<span style="color: #' . $wallet->acsrType['color'] . '">' . $wallet->acsrType['text'] . '</span>';
            })
            ->editColumn('amount', function ($wallet) {
                return number_format($wallet->amount);
            })
            ->editColumn('created_at', function($wallet){
                return Carbon::parse($wallet->created_at)->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function($wallet){
                return Carbon::parse($wallet->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('responsive-icon', function($wallet){
                return null;
            })
            ->rawColumns(['method', 'type'])
            ->toJson();
    }
}