<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MTOApprovalController extends Controller
{
    public function index()
    {
        return view('pages.mto-request-approval', ['route' => 'admin.mto-request-approvals', 'search_heading' => 'SEARCH REQUEST']);
    }
}
