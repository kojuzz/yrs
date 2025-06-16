<?php

namespace App\Http\Resources\UserPortal;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopUpHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'trx_id' => $this->trx_id,
            'amount' => number_format($this->amount).' MMK',
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'status' => $this->acsrStatus,
            'icon' => asset('image/top-up.png')
        ];
    }
}
