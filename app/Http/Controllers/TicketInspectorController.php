<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketInspectorStoreRequest;
use App\Http\Requests\TicketInspectorUpdateRequest;
use App\Repositories\TicketInspectorRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TicketInspectorController extends Controller
{
    protected $ticketInspectorRepository;
    public function __construct(TicketInspectorRepository $ticketInspectorRepository)
    {
        $this->ticketInspectorRepository = $ticketInspectorRepository;
    }
    public function index()
    {
        return view('ticket-inspector.index');
    }
    public function datatable(Request $request)
    {
        if($request->ajax()) {
            return $this->ticketInspectorRepository->datatable($request);
        }
    }
    public function create() {
        return view('ticket-inspector.create');
    }
    public function store(TicketInspectorStoreRequest $request) {
        try {
            $this->ticketInspectorRepository->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            return redirect()->route('ticket-inspector.index')->with('success', 'Ticket inspector created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function edit($id) {
        $ticket_inspector = $this->ticketInspectorRepository->find($id);
        return view('ticket-inspector.edit', compact('ticket_inspector'));
    }
    public function update($id, TicketInspectorUpdateRequest $request) {
        try {
            $this->ticketInspectorRepository->update($id, [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $this->ticketInspectorRepository->find($id)->password
            ]);
            return redirect()->route('ticket-inspector.index')->with('success', 'Ticket inspector updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function destroy($id) {
        try {
            $this->ticketInspectorRepository->delete($id);
            return ResponseService::success([], 'Ticket inspector deleted successfully');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
