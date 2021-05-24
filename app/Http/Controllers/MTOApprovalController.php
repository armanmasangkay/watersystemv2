<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class MTOApprovalController extends Controller
{
    public function index()
    {
        $services = Service::where('status', 'mto_approval')->paginate(20);
        return view('pages.mto-request-approval', ['route' => 'admin.mto-request-approvals', 'search_heading' => 'SEARCH REQUEST', 'services' => $services]);
    }

    public function approve(Request $request)
    {
        $services = Service::find($request->id);
        $services->status = "mto_approved";
        $services->save();

        return redirect(route('admin.mto-request-approvals'));
    }

    public function reject(Request $request)
    {
        $services = Service::find($request->id);
        $services->status = "mto_rejected";
        $services->save();

        return redirect(route('admin.mto-request-approvals'));
    }
}
