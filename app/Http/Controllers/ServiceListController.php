<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceListController extends Controller
{
    public function index(){
        $service = Service::all();

        return view('pages.services-list', [
            'services' => $service
        ]);
    }
}
