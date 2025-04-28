<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletAddAmountStoreRequest;
use App\Http\Requests\WalletReduceAmountStoreRequest;
use App\Models\Wallet;
use App\Repositories\WalletRepository;
use App\Services\WalletService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

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
    public function addAmount() {
        $selected_wallet = old('wallet_id') ? Wallet::find(old('wallet_id')) : null;
        return view('wallet.add-amount', compact('selected_wallet'));
    }
    public function addAmountStore(WalletAddAmountStoreRequest $request) {
        DB::beginTransaction();
        try {
            WalletService::addAmount([
                'wallet_id' => $request->wallet_id,
                'sourceable_id' => null,
                'sourceable_type' => null,
                'type' => 'manual',
                'amount' => $request->amount,
                'description' => $request->description
            ]);
            DB::commit();
            return Redirect::route('wallet.index')->with('success', 'Successfully Added.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput(); // old method input error ပြဖို့ withInput သုံးပေးရပါမယ်
        }
    }
    public function reduceAmount() {
        $selected_wallet = old('wallet_id') ? Wallet::find(old('wallet_id')) : null;
        return view('wallet.reduce-amount', compact('selected_wallet'));
    }
    public function reduceAmountStore(WalletReduceAmountStoreRequest $request) {
        DB::beginTransaction();
        try {
            WalletService::reduceAmount([
                'wallet_id' => $request->wallet_id,
                'sourceable_id' => null,
                'sourceable_type' => null,
                'type' => 'manual',
                'amount' => $request->amount,
                'description' => $request->description
            ]);
            DB::commit();
            return Redirect::route('wallet.index')->with('success', 'Successfully Reduced.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput(); // old method input error ပြဖို့ withInput သုံးပေးရပါမယ်
        }
    }
}
