<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
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
                ->addColumn('action', function($data){
                    return null;
                })
                ->toJson();
        }
    }
}
