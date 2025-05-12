<?php

namespace App\Http\Controllers\Api\UserPortal;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserPortal\ProfileResource;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile()
    {
        $auth_user = Auth::guard('users_api')->user();
        return ResponseService::success(new ProfileResource($auth_user));
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string|min:8|max:20',
            'new_password' => 'required|string|min:8|max:20',
        ]);
        try {
            $auth_user = Auth::guard('users_api')->user();
            if (!Hash::check($request->old_password, $auth_user->password)) {
                throw new Exception('The old password is wrong.');
            }
            $auth_user->update([
                'password' => Hash::make($request->new_password)
            ]);
            return ResponseService::success([], 'Successfully changed password');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
