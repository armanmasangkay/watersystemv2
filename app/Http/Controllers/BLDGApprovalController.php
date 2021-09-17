<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;
use App\Services\ServiceReturnDataArray;
use App\Services\ServicesFromKeyword;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class BLDGApprovalController extends Controller
{

    public function index()
    {
        $services = Service::where('status', 'pending_building_inspection')->paginate(20);
        return view('pages.bldg-request-approval',ServiceReturnDataArray::set('pending_building_inspection', $services));
    }

    public function search(Request $request){
        $services = (new ServicesFromKeyword)->get($request->keyword, 'pending_building_inspection');
        $services = new Paginator($services->all(), 10);

        return view('pages.bldg-request-approval',ServiceReturnDataArray::set('pending_building_inspection', $services));
    }

    public function search_denied(Request $request){
        $services = (new ServicesFromKeyword)->get($request->account_number, 'denied_building_inspection');
        $services = new Paginator($services->all(), 10);

        return view('pages.bldg-request-approval',ServiceReturnDataArray::set('denied_building_inspection', $services) );
    }

    public function approve(Request $request)
    {
        $service = Service::findOrFail($request->id);
        $service->approve();

        return redirect(route('admin.request-approvals'));
    }

    public function reject($id)
    {
        $service = Service::findOrFail($id);
        $service->deny();
        // $service->status = "denied_building_inspection";
        // $service->save();

        return redirect(route('admin.request-approvals'));
    }

    public function undo()
    {
        $services = Service::where('status', 'denied_building_inspection')->paginate(20);
        return view('pages.bldg-request-approval',ServiceReturnDataArray::set('denied_building_inspection', $services) );
    }


    public function undoStatus($id)
    {
        $service = Service::findOrFail($id);
        $service->status = "pending_building_inspection";
        $service->save();

        return redirect(route('admin.request-approvals'));
    }
}
