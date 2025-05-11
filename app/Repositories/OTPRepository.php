<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\OTP;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Contracts\BaseRepository;

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
                'expired_at' => now()->addMinutes(5)->format('Y-m-d H:i:s')
            ]);
            $otp = $this->update($otp->id, [
                'token' => encrypt(['id' => $otp->id, 'email' => $otp->email])
            ]);
        }
        return $otp;
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