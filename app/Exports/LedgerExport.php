<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class LedgerExport implements FromCollection,WithHeadings,WithMapping
{
    use Exportable;

    private $accountNumberToExport;

    public function headings(): array
    {
        return [
            'Account #',
            'Period Covered',
            'Reading date',
            'Meter reading',
            'Consumption',
            'Amount',
            'Surcharge',
            'Meter IPS',
            'Total',
            'Posted By',
            'OR #',
            'Payment date',
            'Payment Amount',
            'Balance',
            'Processed by',
        ];
    }

    public function map($transactions): array
    {
    
        return [
            $transactions->customer_id,
            $transactions->period_covered,
            $transactions->reading_date,
            $transactions->reading_meter,
            $transactions->reading_consumption,
            $transactions->billing_amount,
            $transactions->billing_surcharge,
            $transactions->billing_meter_ips,
            $transactions->billing_total,
            $transactions->posted_by,
            $transactions->payment_or_no,
            $transactions->payment_date,
            $transactions->payment_amount,
            $transactions->balance,
            $transactions->processor,

        ];
    }
   
    public function withAccountNumber($accountNumber)
    {
        $this->accountNumberToExport=$accountNumber;
        return $this;
    }

    public function collection()
    {
        if(!$this->accountNumberToExport)
        {
            throw new \Exception("Account number must be specified first!");
        }

        $transactions=Transaction::leftJoin('users AS PosterUser','transactions.posted_by','=','PosterUser.id')
                             ->leftJoin('users AS PaymentUser','transactions.user_id','=','PaymentUser.id')
                             ->select(DB::raw('transactions.*,PosterUser.name AS posted,PaymentUser.name AS processor'))
                             ->where('customer_id',$this->accountNumberToExport)
                             ->get();
        

        return $transactions;

        
    }
}
