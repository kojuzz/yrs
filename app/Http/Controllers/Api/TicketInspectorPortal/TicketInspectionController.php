<?php

namespace App\Http\Controllers\Api\TicketInspectorPortal;

use Exception;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\TicketInspectorPortal\TicketInspectionResource;
use App\Repositories\TicketInspectionRepository;
use Illuminate\Support\Facades\Auth;
use App\Services\TicketInspectionService;

class TicketInspectionController extends Controller
{
    public function index()
    {
        $ticket_inspector = Auth::guard('ticket_inspectors_api')->user();
        $ticket_inspections = (new TicketInspectionRepository)
            ->queryByTicketInspector($ticket_inspector)
            ->with(['ticket:id,ticket_number,type','route:id,title'])
            ->paginate(10);
        return TicketInspectionResource::collection($ticket_inspections)->additional([
            'message' => 'success'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'route_slug' => 'required|string',
            'qr_token' => 'required|string',
        ], [
            'route_slug.required' => 'The route field is required.',
            'qr_token.required' => 'The QR token field is required.',
        ]);

        try {
            DB::beginTransaction();
            $ticket_inspector = Auth::guard('ticket_inspectors_api')->user();
            $ticket_inspection = TicketInspectionService::scanQR(
                $ticket_inspector, 
                $request->route_slug, 
                $request->qr_token
            );
            DB::commit();
            return ResponseService::success([
                // 'ticket_inspection' => $ticket_inspection
                'ticket_inspection_id' => $ticket_inspection->id
            ], 'Successfully inspected.');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }
}
