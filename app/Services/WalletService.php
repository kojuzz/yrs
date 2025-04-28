<?php

namespace App\Services;

use App\Repositories\WalletRepository;
use App\Repositories\WalletTransactionRepository;

class WalletService
{
    public static function addAmount(array $data)
    {
        // Wallet add Amount
        $wallet = (new WalletRepository())->addAmount($data['wallet_id'], $data['amount']);

        // Wallet Transcation
        (new WalletTransactionRepository())->create([
            'wallet_id' => $wallet->id,
            'user_id' => $wallet->user_id,
            'sourceable_id' => $data['sourceable_id'],
            'sourceable_type' => $data['sourceable_type'],
            'method' => 'add',
            'type' => $data['type'],
            'amount' => $data['amount'],
            'description' => $data['description']
        ]);
    }
}