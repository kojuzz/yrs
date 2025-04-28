<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUserStoreRequest;
use App\Http\Requests\AdminUserUpdateRequest;
use App\Models\AdminUser;
use App\Repositories\AdminUserRepository;
use App\Services\ResponseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class AdminUserController extends Controller
{
    protected $adminUserRepository;
    public function __construct(AdminUserRepository $adminUserRepository)
    {
        $this->adminUserRepository = $adminUserRepository;
    }
    public function index()
    {
        return view('admin-user.index');
    }
    public function datatable(Request $request)
    {
        if($request->ajax()) {
            return $this->adminUserRepository->datatable($request);
        }
    }
    public function create() {
        return view('admin-user.create');
    }
    public function store(AdminUserStoreRequest $request) {
        try {
            $this->adminUserRepository->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            return redirect()->route('admin-user.index')->with('success', 'Admin user created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function edit($id) {
        $admin_user = $this->adminUserRepository->find($id);
        return view('admin-user.edit', compact('admin_user'));
    }
    public function update($id, AdminUserUpdateRequest $request) {
        try {
            $this->adminUserRepository->update($id, [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $this->adminUserRepository->find($id)->password
            ]);
            return redirect()->route('admin-user.index')->with('success', 'Admin user updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function destroy($id) {
        try {
            $this->adminUserRepository->delete($id);
            return ResponseService::success([], 'Admin user deleted successfully');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
