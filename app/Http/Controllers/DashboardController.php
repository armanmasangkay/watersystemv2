<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private function constructArray($title, $count, $url, $icon)
    {
        return [
            'title' =>$title,
            'count' =>$count,
            'url' => $url,
            'icon' => $icon
        ];
    }

    public function index()
    {
        $customerCount = Customer::count();

        $userCount = User::count();

        $servicePendingCount = Service::countNotReady();

        $servicePendingForPaymentCount = Service::countWithStatus('pending_for_payment');

        $data = [
            'customer' => $this->constructArray('Total Customers', $customerCount, route('admin.existing-customers.index'), 'users'),
            'user' => $this->constructArray('Total Users', $userCount, route('admin.users.index'), 'user'),
            'service_pending' =>$this->constructArray('Total Pending Services', $servicePendingCount, route('admin.services.index'), 'activity'),
            'service_pending_for_payment' => $this->constructArray('Total Pending for Payment', $servicePendingForPaymentCount, route('admin.services.filter', ['filter' => Service::$PENDING_FOR_PAYMENT]), 'trending-up')
        ];

        return view('pages.dashboard', [
            'data' => $data
        ]);
    }
}
