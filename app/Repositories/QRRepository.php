<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\QR;
use App\Notifications\TwoStepVerification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Contracts\BaseRepository;
use Exception;
use Illuminate\Support\Facades\Notification;
class QRRepository implements BaseRepository
{
    protected $model;
    public function __construct()
    {
        $this->model = QR::class;
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
    public function generate($ticket_number)
    {
        $qr = $this->model::where('ticket_number', $ticket_number)->where('expired_at', '>', date('Y-m-d H:i:s'))->first();
        if(!$qr) {
            $qr = $this->create([
                'ticket_number' => $ticket_number,
                'token' => Str::uuid(),
                'expired_at' => now()->addMinutes(5)->format('Y-m-d H:i:s')
            ]);
        }
        return $qr;
    }
    public function regenerate($qr_token)
    {
        $qr = $this->model::where('token', $qr_token)->first();
        if(!$qr) {
            throw new Exception('The given data is invalid');
        }
        if($qr->expired_at > date('Y-m-d H:i:s')) {
            throw new Exception('We have already generate the QR for (#' . $qr->ticket_number . '). The QR will expire in ' . now()->diff($qr->expired_at)->format('%i minutes and %s seconds') . '.');
        }

        $ticket_number = $qr->ticket_number;
        $this->delete($qr->id);

        $qr = $this->create([
            'ticket_number' => $ticket_number,
            'token' => Str::uuid(),
            'expired_at' => now()->addMinutes(5)->format('Y-m-d H:i:s')
        ]);
        return $qr;
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