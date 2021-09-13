<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Services\ServiceReturnDataArray;
use App\Services\ServicesFromKeyword;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class EngineerController extends Controller
{
    
    private int $servicesPerPage=10; //used to identify how many services to show when paginated
    
    
    private function createView($services)
    {
        return view(
            'pages.users.engineer.index',
            ServiceReturnDataArray::set(Service::$PENDING_ENGINEER_APPROVAL,$services)
        );
    }
    public function index()
    {
        $services = Service::where('status', Service::$PENDING_ENGINEER_APPROVAL)->paginate($this->servicesPerPage);
        return $this->createView($services);
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

    public function search(Request $request)
    {
        $services = (new ServicesFromKeyword)->get($request->keyword, Service::$PENDING_ENGINEER_APPROVAL);
        $services = new Paginator($services->all(), $this->servicesPerPage);
        return $this->createView($services);
    }
}
