<?php

namespace App\Repositories;

use App\Models\AdminUser;
use App\Repositories\Contracts\BaseRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminUserRepository implements BaseRepository
{
    protected $model;
    public function __construct()
    {
        $this->model = AdminUser::class;
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
            ->editColumn('email_verified_at', function ($admin_user) {
                return $admin_user->email_verified_at ? Carbon::parse($admin_user->email_verified_at)->format('Y-m-d H:i:s') : 'Not verified';
            })
            ->editColumn('created_at', function($admin_user){
                return Carbon::parse($admin_user->created_at)->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function($admin_user){
                return Carbon::parse($admin_user->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function($admin_user){
                return view('admin-user._action', compact('admin_user'));
            })
            ->addColumn('responsive-icon', function($admin_user){
                return null;
            })
            ->toJson();
    }
}