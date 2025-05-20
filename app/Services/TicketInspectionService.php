<?php

namespace App\Services;

use App\Models\QR;
use App\Models\Route;
use App\Models\RouteStation;
use App\Models\Ticket;
use App\Models\TicketInspection;
use App\Repositories\RouteRepository;
use App\Repositories\StationRepository;
use App\Repositories\TicketInspectionRepository;
use App\Repositories\TicketPricingRepository;
use App\Repositories\TicketRepository;
use Carbon\Carbon;
use Exception;

class TicketInspectionService
{
    public static function scanQR($ticket_inspector, $route_slug, $qr_token)
    {
        // Get route
        $route = Route::where('slug', $route_slug)->first();
        if(!$route) {
            throw new Exception('The route is not found.');
        }
        // Get QR
        $qr = QR::where('token', $qr_token)->first();
        if(!$qr) {
            throw new Exception('The QR is invalid.');
        }
        if($qr->expired_at < date('Y-m-d H:i:s')) {
            throw new Exception('The QR is expired.');
        }
        // Get ticket
        $ticket = Ticket::where('ticket_number', $qr->ticket_number)->first();
        if(!$ticket) {
            throw new Exception('The ticket is not found.');
        }
        if(!($ticket->valid_at < date('Y-m-d H:i:s') && $ticket->expire_at >= date('Y-m-d H:i:s'))) {
            throw new Exception('The ticket is not valid.');
        }
        
        // for one time ticket
        if($ticket->type == 'one_time_ticket') {
            // လမ်းကြောင်းမှန်လားစစ်တယ်
            if($ticket->direction != $route->direction) {
                throw new Exception('The ticket direction does not match the route direction.');
            }
            // သုံးပြီးသားလားစစ်တယ်
            if(TicketInspection::where('ticket_id', $ticket->id)->exists()){
                throw new Exception('The ticket has already been inspected.');
            }
        }
        $ticket_inspection = (new TicketInspectionRepository)->create([
            'ticket_id' => $ticket->id,
            'ticket_inspector_id' => $ticket_inspector->id,
            'route_id' => $route->id,
        ]);
        return $ticket_inspection;
    }
}