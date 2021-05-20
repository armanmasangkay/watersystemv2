<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;

class BLDGApprovalController extends Controller
{
    public function index()
    {
        $services = Service::where('status', 'mto_approved')->paginate(20);
        return view('pages.bldg-request-approval', ['route' => 'admin.request-approvals', 'search_heading' => 'SEARCH REQUEST','services' => $services]);
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

        $service = Service::find($request->id);
        $service->building_inspection_schedule = $request->building_inspection_schedule;
        $service->status = "bldg_approved";
        $service->save();

        return redirect(route('admin.request-approvals'));
    }

    public function reject($id)
    {
        $service = Service::find($id);
        $service->building_inspection_schedule = now()->format('Y-m-d');
        $service->status = "bldg_rejected";
        $service->save();

        return redirect(route('admin.request-approvals'));
    }
}
