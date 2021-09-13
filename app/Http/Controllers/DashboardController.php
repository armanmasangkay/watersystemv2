<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        $customerCount = $customers->count();

        $users = User::all();
        $usersCount = $users->count();

        $pending_services = Service::where('status' , '<>', 'ready');
        $pending_services_count = $pending_services->count();

        $pending_services_not_paid = Service::where('status', 'pending_for_payment');
        $pending_services_not_paid_count = $pending_services_not_paid->count();

        dd([$customerCount,$usersCount,$pending_services_count, $pending_services_not_paid_count]);

        return view('pages.dashboard');
    }
}
