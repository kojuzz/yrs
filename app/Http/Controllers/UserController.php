<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userRepository;
    protected $walletRepository;
    public function __construct(UserRepository $userRepository, WalletRepository $walletRepository)
    {
        $this->userRepository = $userRepository;
        $this->walletRepository = $walletRepository;
    }
    public function index()
    {
        return view('user.index');
    }
    public function datatable(Request $request)
    {
        if($request->ajax()) {
            return $this->userRepository->datatable($request);
        }
    }
    public function create() {
        return view('user.create');
    }
    public function store(UserStoreRequest $request) {
        try {
            $user = $this->userRepository->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $this->walletRepository->firstOrCreate([
                'user_id' => $user->id
            ], [
                'amount' => 0
            ]);
            return redirect()->route('user.index')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function edit($id) {
        $user = $this->userRepository->find($id);
        return view('user.edit', compact('user'));
    }
    public function update($id, UserUpdateRequest $request) {
        try {
            $this->userRepository->update($id, [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $this->userRepository->find($id)->password
            ]);
            return redirect()->route('user.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function destroy($id) {
        try {
            $this->userRepository->delete($id);
            return ResponseService::success([], 'User deleted successfully');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
