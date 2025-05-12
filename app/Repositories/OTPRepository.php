<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\OTP;
use App\Notifications\TwoStepVerification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Contracts\BaseRepository;
use Exception;
use Illuminate\Support\Facades\Notification;
class OTPRepository implements BaseRepository
{
    protected $model;
    public function __construct()
    {
        $this->model = OTP::class;
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
    public function send ($email)
    {
        $otp = $this->model::where('email', $email)->where('expired_at', '>', date('Y-m-d H:i:s'))->first();
        if(!$otp) {
            $otp = $this->create([
                'email' => $email,
                'code' => $this->otpCode(),
                'token' => encrypt(['uuid' => Str::uuid(), 'email' => $email]),
                'expired_at' => now()->addMinutes(5)->format('Y-m-d H:i:s')
            ]);
            if(config('app.env') == 'production') {
                Notification::route('mail', $otp->email)->notify(new TwoStepVerification($otp));
            }
        }
        return $otp;
    }
    public function resend($otp_token)
    {
        $decrypted_otp_token = decrypt($otp_token);
        $email = $decrypted_otp_token['email'];

        $otp = OTP::where('token', $otp_token)->first();
        if(!$otp) {
            throw new Exception('The given data is invalid');
        }
        if($otp->expired_at > date('Y-m-d H:i:s')) {
            throw new Exception('We have already sent the OTP to ' . $otp->email . 'The OTP will expire in ' . now()->diff($otp->expired_at)->format('%i minutes and %s seconds') . '.');
        }

        $this->delete($otp->id);

        $otp = $this->create([
            'email' => $email,
            'code' => $this->otpCode(),
            'token' => encrypt(['uuid' => Str::uuid(), 'email' => $email]),
            'expired_at' => now()->addMinutes(5)->format('Y-m-d H:i:s')
        ]);
        if(config('app.env') == 'production') {
            Notification::route('mail', $email)->notify(new TwoStepVerification($otp));
        }
        return $otp;
    }
    public function verify ($otp_token, $code)
    {
        $otp = $this->model::where('token', $otp_token)->first();
        if(!$otp) {
            throw new Exception('The given data is invalid');
        }
        if($otp->expired_at < date('Y-m-d H:i:s')) {
            throw new Exception('the OTP is experied');
        }
        if($otp->code != $code) {
            throw new Exception('The OTP is wrong');
        }
        $this->delete($otp->id);
    }
    private function otpCode ()
    {
        if(config('app.env') == 'production') {
            $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } else {
            $code = '123123';
        }
        return $code;
    }
}