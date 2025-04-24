<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class Select2AjaxController extends Controller
{
    public function wallet(Request $request) {
        $wallets = Wallet::with('user')->paginate(5);
        return $wallets;
    }
}
