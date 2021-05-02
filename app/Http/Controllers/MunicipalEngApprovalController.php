<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MunicipalEngApprovalController extends Controller
{
    public function index()
    {
        return view('pages.mun-eng-request-approval', ['route' => 'admin.me-request-approvals', 'search_heading' => 'SEARCH REQUEST']);
    }
}
