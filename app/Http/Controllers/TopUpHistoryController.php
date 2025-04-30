<?php

namespace App\Http\Controllers;

use App\Repositories\TopUpHistoryRepository;
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
}
