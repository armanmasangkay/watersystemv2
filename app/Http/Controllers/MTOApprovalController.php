<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class MTOApprovalController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('status', 'mto_approval')->paginate(20);
        return view('pages.mto-request-approval', ['route' => 'admin.mto-request-approvals', 'search_heading' => 'SEARCH REQUEST', 'transactions' => $transactions]);
    }
}
