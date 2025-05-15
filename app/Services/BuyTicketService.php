<?php

namespace App\Services;

use App\Models\Ticket;
use App\Repositories\TicketPricingRepository;
use App\Repositories\TicketRepository;
use Carbon\Carbon;
use Exception;

class BuyTicketService
{
    public static function create($user, $date_time, $type, $origin_station_slug, $destination_station_slug)
    {
        if($type == 'one_time_ticket') {
            return 'one_time_ticket';
        } else if($type == 'one_month_ticket') {
            $ticket_pricing = (new TicketPricingRepository)->queryByDateTime($date_time)->where('type', $type)->lockForUpdate()->first();
            if(!$ticket_pricing) {
                throw new Exception('Ticket not found.');
            }
            if($ticket_pricing->remain_quantity <= 0) {
                throw new Exception('Ticket is sold out.');
            }
            $ticket_pricing->decrement('remain_quantity', 1);
            $ticket_pricing->update();
            
            $ticket = (new TicketRepository())->create([
                'ticket_number' => null,
                'user_id' => $user->id,
                'ticket_pricing_id' => $ticket_pricing->id,
                'type' => $ticket_pricing->type,
                'direction' => $ticket_pricing->direction,
                'price' => $ticket_pricing->price,
                'valid_at' => Carbon::parse($date_time)->startOfMonth()->format('Y-m-d H:i:s'),
                'expire_at' => Carbon::parse($date_time)->endOfMonth()->format('Y-m-d H:i:s'),
            ]);
            $ticket = (new TicketRepository())->update($ticket->id, [
                'ticket_number' => str_pad($ticket->id, 9, '0', STR_PAD_LEFT)
            ]);

            $wallet = $user->wallet;
            if(!$wallet) {
                throw new Exception('Wallet not found.');
            }
            if($wallet->amount < $ticket_pricing->price) {
                throw new Exception('Insufficient balance.');
            }
            WalletService::reduceAmount([
                'wallet_id' => $user->wallet->id,
                'sourceable_id' => $ticket->id,
                'sourceable_type' => Ticket::class,
                'type' => 'buy_ticket',
                'amount' => $ticket_pricing->price,
                'description' => 'Buy Ticket (#' . $ticket->ticket_number . ')',
            ]);
            return $ticket;
        }
    }
}