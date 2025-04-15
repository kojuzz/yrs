<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminUserController extends Controller
{
    public function index()
    {
        return view('admin-user.index');
    }
    public function datatable(Request $request)
    {
        if($request->ajax()) {
            $model = AdminUser::query();
            return DataTables::eloquent($model)
                ->editColumn('created_at', function($data){
                    return Carbon::parse($data->created_at)->format('Y-m-d H:i:s');
                })
                ->editColumn('updated_at', function($data){
                    return Carbon::parse($data->updated_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function($data){
                    return null;
                })
                ->addColumn('responsive-icon', function($data){
                    return null;
                })
                ->toJson();
        }
    }
}
