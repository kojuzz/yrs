<?php

namespace App\Http\Controllers\Api\UserPortal;

use App\Http\Controllers\Controller;
use App\Repositories\TopUpHistoryRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TopUpController extends Controller
{
    protected $topUpHistoryRepository;
    public function __construct(TopUpHistoryRepository $topUpHistoryRepository)
    {
        $this->topUpHistoryRepository = $topUpHistoryRepository;
    }
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,heic,gif,svg|max:5120',
        ]);
        try {
            DB::beginTransaction();
            $user = Auth::guard('users_api')->user();
            $wallet = $user->wallet;
            if(!$wallet) {
                throw new Exception('Thi given data is invalid.');
            }
            $image = $request->file('image');
            $image_name = Str::random(6) . date('YmdHis') . '.' . $image->getClientOriginalExtension();
            Storage::put('top-up-history/' . $image_name, file_get_contents($image));
            $top_up_history = $this->topUpHistoryRepository->create([
                'trx_id' => Str::random(12),
                'wallet_id' => $wallet->id,
                'user_id' => $user->id,
                'amount' => $request->amount,
                'description' => $request->description,
                'image' => $image_name,
                'status' => 'pending',
            ]);
            DB::commit();
            return ResponseService::success([
                'trx_id' => $top_up_history->trx_id,
            ], 'success');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }
}
