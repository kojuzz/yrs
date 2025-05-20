<?php

namespace App\Http\Resources\TicketInspectorPortal;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketInspectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ticket_number' => $this->ticket->ticket_number ?? '-',
            'route_title' => $this->route->title ?? '-',
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'icon' => $this->ticket ? $this->ticket->acsrType['icon'] : asset('image/ticket.png'),
        ];
    }
}
