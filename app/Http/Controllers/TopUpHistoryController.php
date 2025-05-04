<?php

namespace App\Http\Controllers;

use App\Repositories\TopUpHistoryRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopUpHistoryController extends Controller
{
    protected $topUpHistoryRepository;
    public function __construct(TopUpHistoryRepository $topUpHistoryRepository)
    {
        $this->topUpHistoryRepository = $topUpHistoryRepository;
    }

    public function index()
    {
        return view('top-up-history.index');
    }
    public function show($id)
    {
        $top_up_history = $this->topUpHistoryRepository->find($id);
        return view('top-up-history.show', compact('top_up_history'));
    }
    public function datatable(Request $request)
    {
        if($request->ajax()) {
            return $this->topUpHistoryRepository->datatable($request);
        }
    }
    public function approve($id) {
        DB::beginTransaction();
        try {
            $this->topUpHistoryRepository->approve($id);
            DB::commit();
            return ResponseService::success([], 'Successfully Approved');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }
    public function reject($id) {
        DB::beginTransaction();
        try {
            $this->topUpHistoryRepository->reject($id);
            DB::commit();
            return ResponseService::success([], 'Successfully Rejected');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }
}
