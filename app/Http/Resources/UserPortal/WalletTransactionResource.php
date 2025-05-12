<?php

namespace App\Http\Resources\UserPortal;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransactionResource extends JsonResource
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
            'method' => $this->acsr_method,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'icon' => $this->acsr_type['icon']
        ];
    }
}
