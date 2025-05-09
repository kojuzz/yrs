<?php

namespace App\Http\Controllers;

use App\Repositories\TicketRepository;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $ticketRepository;
    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

        public function index()
        {
            return view('ticket.index');
        }

        public function datatable(Request $request)
        {
            if($request->ajax()) {
                return $this->ticketRepository->datatable($request);
            }
        }
        public function show($id)
        {
            $ticket = $this->ticketRepository->find($id);
            return view('ticket.show', compact('ticket'));
        }

    public function create() {}
    public function store() {}
    public function edit() {}
    public function update() {}
    public function destroy($id) {}
}
