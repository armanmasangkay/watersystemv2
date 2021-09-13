<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceListController extends Controller
{
    public function index(){
        $services = Service::paginate(15);
        $status = Service::getServiceStatus();

        return view('pages.services-list', [
            'services' => $services,
            'status' => $status
        ]);
    }

    public function filter(Request $request){
        if($request->filter == 'none'){
            return redirect(route('admin.services-list.index'));
        }
        $services = Service::where('status', $request->filter)->paginate(10);
        $status = Service::getServiceStatus();

        return view('pages.services-list', [
            'services' => $services,
            'status' => $status
        ]);
    }
}
