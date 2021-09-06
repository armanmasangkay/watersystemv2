<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceListController extends Controller
{
    public function index(){
        $services = Service::paginate(15);

        return view('pages.services-list', [
            'services' => $services
        ]);
    }

    public function filter(Request $request){
        if($request->filter == 'none'){
            return redirect(route('admin.services-list.index'));
        }
        $services = Service::where('status', $request->filter)->paginate(10);

        return view('pages.services-list', [
            'services' => $services
        ]);
    }
}
