<?php

namespace App\Http\Controllers;

use App\Models\PaymentWorkOrder;
use Illuminate\Http\Request;

class WorkOrderPaymentsController extends Controller
{
    public function index(Request $request)
    {
        $payments=PaymentWorkOrder::orderBy('updated_at','desc')->paginate(15);
      
        return view('pages.work-order-payments',[
            'payments'=>$payments
        ]);
    }
}
