<?php

namespace App\Http\Resources\UserPortal;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ticket_number' => $this->ticket_number,
            'type' => $this->acsrType,
            'direction' => $this->acsrDirection,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
        ];
    }
}
