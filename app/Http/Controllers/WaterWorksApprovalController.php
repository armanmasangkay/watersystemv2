<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaterWorksApprovalController extends Controller
{
    public function index()
    {
        return view('pages.waterworks-request-approval', ['route' => 'admin.waterworks-request-approvals', 'search_heading' => 'SEARCH REQUEST']);
    }
}
