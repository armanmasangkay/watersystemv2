<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;

class WaterWorksApprovalController extends Controller
{
    public function index()
    {
        $services = Service::where('status', 'bldg_approved')->paginate(20);
        return view('pages.waterworks-request-approval', ['route' => 'admin.waterworks-request-approvals', 'search_heading' => 'SEARCH REQUEST', 'services' => $services]);
    }

    public function approve(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'building_inspection_schedule'=> 'required|date|after_or_equal:'.now()->format('Y-m-d')
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $services = Service::find($request->id);
        $services->water_works_schedule = $request->building_inspection_schedule;
        $services->status = "waterworks_approved";
        $services->save();

        return redirect(route('admin.waterworks-request-approvals'));
    }

    public function reject($id)
    {
        $services = Service::find($id);
        $services->water_works_schedule = now()->format('Y-m-d');
        $services->status = "waterworks_rejected";
        $services->save();

        return redirect(route('admin.waterworks-request-approvals'));
    }
}
