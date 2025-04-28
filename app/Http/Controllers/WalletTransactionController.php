<?php

namespace App\Http\Controllers;

use App\Repositories\WalletTransactionRepository;
use Illuminate\Http\Request;

class WalletTransactionController extends Controller
{
    protected $walletTransactionRepository;
    public function __construct(WalletTransactionRepository $walletTransactionRepository)
    {
        $this->walletTransactionRepository = $walletTransactionRepository;
    }

    public function index()
    {
        return view('wallet-transaction.index');
    }
    public function datatable(Request $request)
    {
        if($request->ajax()) {
            return $this->walletTransactionRepository->datatable($request);
        }
    }
}
