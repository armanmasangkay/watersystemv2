<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaction;

class BLDGApprovalController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('status', 'mto_approved')->paginate(20);
        return view('pages.bldg-request-approval', ['route' => 'admin.request-approvals', 'search_heading' => 'SEARCH REQUEST','transactions' => $transactions]);
    }
}
