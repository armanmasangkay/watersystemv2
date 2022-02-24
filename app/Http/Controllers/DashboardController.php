<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Service;
use App\Models\Surcharge;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WaterRate;
use Carbon\Carbon;
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


    /*
        This will look for customers that exceeds 35 days from their previous reading date
        and automatically create a bill for them
    */

    private function autoGenerateBill()
    {
        $activeCustomers=Customer::where('connection_status',Customer::ACTIVE)->get();

        foreach($activeCustomers as $customer){

            $lastTransaction=$customer->getLatestTransaction();

            if($lastTransaction){
                $numOfTransactionsToCreate=ceil(Carbon::parse($lastTransaction->reading_date)->diffInDays(now())/35)+1;

                for($i=0;$i<$numOfTransactionsToCreate;$i++){
                    $lastTransaction=$customer->getLatestTransaction();
                    // dd($lastTransaction->reading_date);
                    
                    if(!is_null($lastTransaction)){
                        
                        $lastReadingDate= Carbon::parse($lastTransaction->reading_date);
        
                        $isPast35Days=$lastReadingDate->diffInDays(now())>35;
                        $residentialAndInstitutionalRate=WaterRate::where("type","Residential")->first()->min_rate;
                        $commercialRate=WaterRate::where("type","Commercial")->first()->min_rate;
                        $billingAmount=$lastTransaction->customer->connection_type==Customer::CT_RESIDENTIAL_INSTITUTIONAL?$residentialAndInstitutionalRate:$commercialRate;
                        $surchargeRate=Surcharge::all()->first()->rate;
                    
                        if($isPast35Days){
                        
                            $periodCoveredFrom=Carbon::parse($lastTransaction->reading_date);
                            $periodCoveredFromStr=Carbon::parse($lastTransaction->reading_date)->toFormattedDateString();
                            $periodCoveredTo=$periodCoveredFrom->addDays(35);
                            $periodCoveredToStr=$periodCoveredTo->toFormattedDateString();
                            $periodCovered=$periodCoveredFromStr . "-" . $periodCoveredToStr;
                            $readingDate=$periodCoveredTo->toDateString();
                            $meterReading=$lastTransaction->reading_meter;

                            $newSurchage=$lastTransaction->billing_amount*$surchargeRate;
                            $lastTransaction->billing_surcharge=$newSurchage;
                            $lastTransaction->billing_total=$lastTransaction->billing_total+$newSurchage;
                            $lastTransaction->balance=$lastTransaction->balance+$newSurchage;
                            $lastTransaction->update();

                            Transaction::create([
                                'customer_id'=>$customer->account_number,
                                'period_covered'=>$periodCovered,
                                'reading_date'=>$readingDate,
                                'reading_meter'=>$meterReading,
                                'reading_consumption'=>0,
                                'billing_amount'=>$billingAmount,
                                'billing_surcharge'=>0,
                                'billing_meter_ips'=>$lastTransaction->billing_meter_ips,
                                'billing_total'=>$billingAmount,
                                'payment_or_no',
                                'payment_date',
                                'payment_amount',
                                'balance'=>$lastTransaction->balance+$billingAmount,
                                'user_id',
                                'posted_by'
                            ]);
                        }
                    }
                } 
            }
        }
    }


    public function index()
    {
        $this->autoGenerateBill();

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
