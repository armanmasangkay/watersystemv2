<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class WorkOrderController extends Controller
{
    public function index()
    {
        $services = Service::where('status', 'ready');
        return view('pages.work-order', ['services' => $services]);
    }
}
