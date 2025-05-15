<?php

namespace App\Http\Controllers\Api\UserPortal;

use App\Http\Controllers\Controller;
use App\Services\BuyTicketService;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BuyTicketController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => ['required', Rule::in(['one_time_ticket', 'one_month_ticket'])],
            'origin_station_slug' => 'required_if:type,one_time_ticket',
            'destination_station_slug' => 'required_if:type,one_time_ticket'
        ], [
            'origin_station_slug.required_if' => 'The origin station field is required in one time ticket.',
            'destination_station_slug.required_if' => 'The destination station field is required in one time ticket.',
        ]);
        try {
            DB::beginTransaction();
            $user = Auth::guard('users_api')->user();
            $date_time = date('Y-m-d H:i:s');
            $origin_station_slug = $request->origin_station_slug;
            $destination_station_slug = $request->destination_station_slug;
            $ticket = BuyTicketService::create($user, $date_time, $request->type, $origin_station_slug, $destination_station_slug);            
            DB::commit();
            return ResponseService::success([
                'ticket_number' => $ticket->ticket_number
            ], 'Successfully Completed');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }

    }
}
