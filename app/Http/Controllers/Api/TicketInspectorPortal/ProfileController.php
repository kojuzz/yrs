<?php

namespace App\Http\Controllers\Api\TicketInspectorPortal;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketInspectorPortal\ProfileResource;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile()
    {
        $ticket_inspector = Auth::guard('ticket_inspectors_api')->user();
        return ResponseService::success(new ProfileResource($ticket_inspector));
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string|min:8|max:20',
            'new_password' => 'required|string|min:8|max:20',
        ]);
        try {
            $ticket_inspector = Auth::guard('ticket_inspectors_api')->user();
            if (!Hash::check($request->old_password, $ticket_inspector->password)) {
                throw new Exception('The old password is wrong.');
            }
            $ticket_inspector->update([
                'password' => Hash::make($request->new_password)
            ]);
            return ResponseService::success([], 'Successfully changed password');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
