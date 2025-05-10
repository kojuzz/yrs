<?php

namespace App\Http\Controllers\Api\UserPortal;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max: 50',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|max:20'
        ]);
        // return $request->all();
        try {
            DB::beginTransaction();
            $user = (new UserRepository)->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            (new WalletRepository)->firstOrCreate([
                'user_id' => $user->id,
            ], [
                'amount' => 0
            ]);
            $response = [
                'access_token' => $user->createToken(config('app.name'))->plainTextToken
            ];
            DB::commit();
            return ResponseService::success($response, 'Successfully registered');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }
}
