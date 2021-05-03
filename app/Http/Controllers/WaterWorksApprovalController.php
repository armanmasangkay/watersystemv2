<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class WaterWorksApprovalController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('status', 'bldg_approved')->paginate(20);
        return view('pages.waterworks-request-approval', ['route' => 'admin.waterworks-request-approvals', 'search_heading' => 'SEARCH REQUEST', 'transactions' => $transactions]);
    }
}
