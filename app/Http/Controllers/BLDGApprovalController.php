<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BLDGApprovalController extends Controller
{
    public function index()
    {
        return view('pages.bldg-request-approval', ['route' => 'admin.request-approvals', 'search_heading' => 'SEARCH REQUEST']);
    }
}