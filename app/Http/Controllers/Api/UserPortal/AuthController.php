<?php

namespace App\Http\Controllers\Api\UserPortal;

use App\Http\Controllers\Controller;
use App\Repositories\OTPRepository;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Termwind\Components\Ol;

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
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        try {
            DB::beginTransaction();
            if (Auth::guard('users')->attempt([ 'email' => $request->email, 'password' => $request->password ])){
                $user = Auth::guard('users')->user();
                if ($user->email_verified_at) {
                    $response = [
                        'is_verified' => 1,
                        'access_token' => $user->createToken(config('app.name'))->plainTextToken
                    ];
                } else {
                    // make data at OTP table
                    $otp = (new OTPRepository)->send($request->email);
                    $response = [
                        'is_verified' => 0,
                        'otp_token' => $otp->token
                    ];
                }
            } else {
                throw new Exception('These credentials do not match our records');
            }
            DB::commit();
            return ResponseService::success($response, 'Successfully logged in');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }
    public function logout(Request $request)
    {
        try {
            // $request->user()->currentAccessToken()->delete();
            $request->user()->tokens()->delete();
            return ResponseService::success([], 'Successfully logged out');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
