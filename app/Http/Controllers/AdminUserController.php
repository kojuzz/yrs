<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUserStoreRequest;
use App\Http\Requests\AdminUserUpdateRequest;
use App\Models\AdminUser;
use App\Services\ResponseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
    public function create() {
        return view('admin-user.create');
    }
    public function store(AdminUserStoreRequest $request) {
        try {
            AdminUser::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            return redirect()->route('admin-user.index')->with('success', 'Admin user created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function edit(AdminUser $admin_user) {
        return view('admin-user.edit', compact('admin_user'));
    }
    public function update(AdminUser $admin_user, AdminUserUpdateRequest $request) {
        try {
            $admin_user->name = $request->name;
            $admin_user->email = $request->email;
            $admin_user->password = $request->password ? Hash::make($request->password) : $admin_user->password;
            $admin_user->update();
            return redirect()->route('admin-user.index')->with('success', 'Admin user updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function destroy(AdminUser $admin_user) {
        try {
            // throw new Exception('hello');
            $admin_user->delete();
            return ResponseService::success([], 'Admin user deleted successfully');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
