<?php

namespace App\Http\Controllers\Api\UserPortal;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserPortal\WalletTransactionDetailResource;
use App\Http\Resources\UserPortal\WalletTransactionResource;
use App\Repositories\WalletTransactionRepository;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletTransactionController extends Controller
{
    protected $walletTransactionRepository;
    public function __construct(WalletTransactionRepository $walletTransactionRepository)
    {
        $this->walletTransactionRepository = $walletTransactionRepository;
    }

    public function index(Request $request)
    {
        $user = Auth::guard('users_api')->user();
        $wallet_transactions = $this->walletTransactionRepository->queryByUser($user)
            ->when($request->has('search'), function ($q1) use ($request) {
                $q1->where('trx_id', 'LIKE', "%{$request->search}%")
                    ->orWhere('amount', 'LIKE', "%{$request->search}%")
                    ->orWhere('created_at', 'LIKE', "%{$request->search}%");
                })
            ->orderByDesc('id')
            ->paginate(10);
        return WalletTransactionResource::collection($wallet_transactions)->additional(['message' => 'success']);
    }
    public function show($trx_id)
    {
        $user = Auth::guard('users_api')->user();
        $wallet_transactions = $this->walletTransactionRepository->queryByUser($user)
            ->with(['user:id,name,email', 'sourceable'])
            ->where('trx_id', $trx_id)
            ->firstOrFail();
        return ResponseService::success(new WalletTransactionDetailResource($wallet_transactions), 'success');
    }
}
