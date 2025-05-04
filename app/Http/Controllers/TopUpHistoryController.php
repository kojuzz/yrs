<?php

namespace App\Http\Controllers;

use App\Repositories\TopUpHistoryRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;

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
    public function reject($id) {
        try {
            $this->topUpHistoryRepository->reject($id);
            return ResponseService::success([], 'Successfully Rejected');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
