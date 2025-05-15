<?php

namespace App\Http\Controllers\Api\UserPortal;

use App\Http\Controllers\Controller;
use App\Repositories\TicketPricingRepository;
use App\Services\ResponseService;

class TicketPricingController extends Controller
{
    protected $ticketPricingRepository;
    public function __construct(TicketPricingRepository $ticketPricingRepository)
    {
        $this->ticketPricingRepository = $ticketPricingRepository;
    }

    public function index()
    {
        $pricing = [];
        $ticket_pricings = $this->ticketPricingRepository->queryByDateTime(date('Y-m-d H:i:s'))->get();
        foreach (['one_time_ticket', 'one_month_ticket'] as $type) {
            $filtered_ticket_pricings = $ticket_pricings->where('type', $type);
            if (count($filtered_ticket_pricings)) {
                if($type == 'one_time_ticket') {
                    $pricing[] = [
                        'type' => $type,
                        'title' => 'One Time Ticket',
                        'price' => implode(', ', collect($filtered_ticket_pricings)->map(function($filtered_ticket_pricing) {
                            return $filtered_ticket_pricing->acsrDirection['text'] . ' - ' . number_format($filtered_ticket_pricing->price) . ' MMK';
                        })->toArray()),
                        'description' => 'One Time Ticket vilid for on journey. The ticket will be expired after one journey.',
                    ];
                } else if($type == 'one_month_ticket') {
                    $pricing[] = [
                        'type' => $type,
                        'title' => 'One Month Ticket',
                        'price' => implode(', ', collect($filtered_ticket_pricings)->map(function($filtered_ticket_pricing) {
                            return number_format($filtered_ticket_pricing->price) . ' MMK';
                        })->toArray()),
                        'description' => 'One Month Ticket vilid for one month. The ticket will be expired after one month.',
                    ];
                }
            }
        }
        return ResponseService::success($pricing, 'success');
    }
}
