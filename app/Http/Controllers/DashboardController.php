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
        $customerCount = Customer::count();

        $userCount = User::count();

        $servicePendingCount = Service::countNotReady();

        $servicePendingForPaymentCount = Service::countWithStatus('pending_for_payment');

        $data = [
            'customer' =>[
                'title' => 'Number of Customer',
               'count' => $customerCount
            ] ,
            'user' =>[
                'title' => 'Number of User',
                'count' => $userCount
            ],
            'service_pending' =>[
                'title' => 'Number of Pending Services',
                'count' => $servicePendingCount
            ],
            'service_pending_for_payment' => [
                'title' => 'Number of Pending for Payment',
                'count' => $servicePendingForPaymentCount
            ]
        ];

        return view('pages.dashboard', [
            'data' => $data
        ]);
    }
}
