<?php

namespace App\Repositories;

use App\Models\Wallet;
use App\Repositories\Contracts\BaseRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WalletRepository implements BaseRepository
{
    protected $model;
    public function __construct()
    {
        $this->model = Wallet::class;
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
    public function firstOrCreate(array $data1, array $data2)
    {
        $record = $this->model::firstOrCreate($data1, $data2);
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
        $model = Wallet::query();
        return DataTables::eloquent($model)
            ->addColumn('user_name', function ($wallet) {
                return ($wallet->user->name ?? '-'). ' (' . ($wallet->user->email ?? '-'). ')';
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
            ->toJson();
    }
}