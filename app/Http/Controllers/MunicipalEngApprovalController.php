<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Services\ServiceReturnDataArray;
use Illuminate\Http\Request;

class MunicipalEngApprovalController extends Controller
{
    public function index()
    {
        $services = Service::where('status', Service::$PENDING_ENGINEER_APPROVAL)->paginate(20);
        return view('pages.mun-eng-request-approval', ServiceReturnDataArray::set('pending_engineer_approval',$services));
    }

    public function approve(Request $request)
    {
        $service=Service::findOrFail($request->id);
        $service->approve();

        return back();
    }

    public function deny(Request $request)
    {
        $service=Service::findOrFail($request->id);
        $service->deny();
        return back();
    }
}
