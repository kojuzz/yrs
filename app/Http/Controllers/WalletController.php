<?php

namespace App\Http\Controllers;

use App\Repositories\WalletRepository;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    protected $walletRepository;
    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }
    public function index()
    {
        return view('wallet.index');
    }
    public function datatable(Request $request)
    {
        if($request->ajax()) {
            return $this->walletRepository->datatable($request);
        }
    }
}
