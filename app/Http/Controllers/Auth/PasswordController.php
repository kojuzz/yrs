<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.change-password', [
            'user' => $request->user(),
        ]);
    }
    public function update(ChangePasswordRequest $request): RedirectResponse
    {
        try {
            $request->user()->update([
                'password' => Hash::make($request->password),
            ]);
            return back()->with('success', 'Successfuly Changed.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
