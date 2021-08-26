<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;

class WaterWorksApprovalController extends Controller
{
    public function index()
    {
        $services = Service::where('status', 'pending_waterworks_inspection')->paginate(20);
        return view('pages.waterworks-request-approval', ['route' => 'admin.waterworks-request-approvals', 'search_heading' => 'SEARCH REQUEST', 'services' => $services]);
    }

    public function approve(Request $request)
    {
        // $validator = Validator::make($request->all(),[
        //     'building_inspection_schedule'=> 'required|date|after_or_equal:'.now()->format('Y-m-d')
        // ]);

        // if($validator->fails())
        // {
        //     return back()->withErrors($validator)->withInput();
        // }

        $services = Service::findOrFail($request->id);
        $services->status = "waterworks_approved";
        $services->save();

        return redirect(route('admin.waterworks-request-approvals'));
    }

    public function reject($id)
    {
        $services = Service::findOrFail($id);
        $services->status = "denied_waterworks_request";
        $services->save();

        return redirect(route('admin.waterworks-request-approvals'));
    }
}
