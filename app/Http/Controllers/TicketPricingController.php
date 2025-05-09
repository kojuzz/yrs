<?php

namespace App\Http\Controllers;

use App\Repositories\TicketPricingRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketPricingController extends Controller
{
    protected $ticketPricingRepository;
    public function __construct(TicketPricingRepository $ticketPricingRepository)
    {
        $this->ticketPricingRepository = $ticketPricingRepository;
    }

    public function index()
    {
        return view('ticket-pricing.index');
    }

    public function datatable(Request $request)
    {
        if($request->ajax()) {
            return $this->ticketPricingRepository->datatable($request);
        }
    }

    public function create() {
        return view('ticket-pricing.create');
    }

    public function store(Request $request) {
        try {
            $location = explode(',', $request->location);
            $this->ticketPricingRepository->create([
                'slug' => Str::slug($request->title) .'-'. Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'latitude' => $location[0],
                'longitude' => $location[1],
            ]);
            return redirect()->route('ticket-pricing.index')->with('success', 'Ticket Pricing created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function show($id)
    {
        $ticket_pricing = $this->ticketPricingRepository->find($id);
        return view('ticket-pricing.show', compact('ticket_pricing'));
    }

    public function edit($id) 
    {
        $ticket_pricing = $this->ticketPricingRepository->find($id);
        return view('ticket-pricing.edit', compact('ticket_pricing'));
    }

    public function update($id, Request $request) {
        try {
            $location = explode(',', $request->location);
            $this->ticketPricingRepository->update($id, [
                'slug' => Str::slug($request->title) .'-'. Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'latitude' => $location[0],
                'longitude' => $location[1],
            ]);
            return redirect()->route('ticket-pricing.index')->with('success', 'Ticket Pricing updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id) {
        try {
            $this->ticketPricingRepository->delete($id);
            return ResponseService::success([], 'Ticket Pricing deleted successfully');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
