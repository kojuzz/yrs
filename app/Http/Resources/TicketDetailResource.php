<?php

namespace App\Http\Resources;

use App\Repositories\QRRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'qr_token' => (new QRRepository)->generate($this->ticket_number)->token,
            'ticket_number' => $this->ticket_number,
            'type' => $this->acsrType,
            'direction' => $this->acsrDirection,
            'price' => $this->price . ' MMK',
            'valid_at' => Carbon::parse($this->valid_at)->format('d-m-Y H:i:s'),
            'expire_at' => Carbon::parse($this->expire_at)->format('d-m-Y H:i:s'),
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
        ];
    }
}
