<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private function constructArray($title, $count, $url)
    {
        return [
            'title' =>$title,
            'count' =>$count,
            'url' => $url,
        ];
    }

    public function index()
    {
        $customerCount = Customer::count();

        $userCount = User::count();

        $servicePendingCount = Service::countNotReady();

        $servicePendingForPaymentCount = Service::countWithStatus('pending_for_payment');

        $data = [
            'customer' => $this->constructArray('Number of Customer', $customerCount, route('admin.existing-customers.index')),
            'user' => $this->constructArray('Number of User', $userCount, route('admin.users.index')),
            'service_pending' =>$this->constructArray('Number of Pending Services', $servicePendingCount, route('admin.services-list.index')),
            'service_pending_for_payment' => $this->constructArray('Number of Pending for Payment', $servicePendingForPaymentCount, route('admin.services-list.index'))
        ];

        return view('pages.dashboard', [
            'data' => $data
        ]);
    }
}
