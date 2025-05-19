<?php

namespace App\Http\Controllers\Api\TicketInspectorPortal;

use App\Http\Controllers\Controller;
use App\Repositories\OTPRepository;
use App\Repositories\TicketInspectorRepository;
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
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        try {
            DB::beginTransaction();
            if (Auth::guard('ticket_inspectors')->attempt([ 'email' => $request->email, 'password' => $request->password ])){
                $user = Auth::guard('ticket_inspectors')->user();
                if ($user->email_verified_at) {
                    $response = [
                        'is_verified' => 1,
                        'access_token' => $user->createToken(config('app.name'))->plainTextToken
                    ];
                } else {
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
    public function twoStepVerification(Request $request)
    {
        $request->validate([
            'otp_token' => 'required|string',
            'code' => 'required|string'
        ]);
        try {
            DB::beginTransaction();
            // verify OTP
            (new OTPRepository)->verify($request->otp_token, $request->code);
            // user email ကို decrypt လုပ်ပြီးစစ်
            $decrypted_otp_token = decrypt($request->otp_token);
            $ticket_inspector = (new TicketInspectorRepository)->findByEmail($decrypted_otp_token['email']);
            if(!$ticket_inspector) {
                throw new Exception('The user is not found');
            }
            $ticket_inspector = (new TicketInspectorRepository)->update($ticket_inspector->id, [
                'email_verified_at' => date('Y-m-d H:i:s')
            ]);
            DB::commit();
            // access token ချပေး
            return ResponseService::success([
                'access_token' => $ticket_inspector->createToken(config('app.name'))->plainTextToken
            ], 'Suffessfully logged in');            
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }
    public function resendOTP(Request $request)
    {
        $request->validate([
            'otp_token' => 'required|string'
        ]);
        try {
            DB::beginTransaction();
            $otp = (new OTPRepository)->resend($request->otp_token);
            DB::commit();
            return ResponseService::success([
                'otp_token' => $otp->token
            ], 'Successfully resend OTP');
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
