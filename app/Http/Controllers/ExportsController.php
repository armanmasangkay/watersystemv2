<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Exports\LedgerExport;
use App\Services\CustomersFromKeyword;
use Illuminate\Http\Request;

class ExportsController extends Controller
{
    public function exportCustomers($keyword=null)
    {
        $customersExport=new CustomersExport();
        if($keyword)
        {   
            $customers=(new CustomersFromKeyword)->get($keyword);
            return $customersExport->withData($customers)->download("$keyword.xlsx");
        }
        return $customersExport->download('customers.xlsx');
    }

    public function exportLedger($account_number)
    {
        return (new LedgerExport)->withAccountNumber($account_number)->download("$account_number ledger.xlsx");
    }
}
