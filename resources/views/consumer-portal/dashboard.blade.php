@extends('layout.main-alt')

@section('title','Consumer Dashboard')

@section('content')
<div class="my-4">
    <h1 class="display-6">Ledger Card</h1>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <caption>Showing only transactions from today to a year ago</caption>
        <thead class="table-dark">
          <tr>
            <th scope="col">Period Covered</th>
            <th scope="col">Reading Date</th>
            <th scope="col">Meter Reading</th>
            <th scope="col">Consumption</th>
            <th scope="col">Billing Amount</th>
            <th scope="col">Surcharge</th>
            <th scope="col">Meter Installment Bal.</th>
            <th scope="col">Total</th>
            <th scope="col">Outstanding Bal.</th>
            <th scope="col">Posted By</th>
            <th scope="col">OR #</th>
            <th scope="col">Date Paid</th>
            <th scope="col">Amount Paid</th>
            <th scope="col">Payment Posted By</th>
          </tr>
        </thead>
        <tbody>

          @forelse ($transactions as $transaction)
            <tr>
                <td>{{$transaction->period_covered}}</td>
                <td>{{$transaction->reading_date}}</td>
                <td>{{$transaction->reading_meter}}</td>
                <td>{{$transaction->reading_consumption}}</td>
                <td>{{$transaction->getBillingAmountFormatted()}}</td>
                <td>{{$transaction->getSurchargeFormatted()}}</td>
                <td>{{$transaction->getMeterIPBalanceFormatted()}}</td>
                <td>{{$transaction->getBillingTotalFormatted()}}</td>
                <td>{{$transaction->getOutstandingBalanceFormatted()}}</td>
                <td>{{$transaction->getNameOfBillCreator()}}</td>
                <td>{{$transaction->payment_or_no}}</td>
                <td>{{$transaction->payment_date}}</td>
                <td>{{$transaction->payment_amount}}</td>
                <td>{{$transaction->getNameOfBillCreator()}}</td>
             //TODO:: Continue working with the data. Make sure that it shows the oldest first to the newest
            
            </tr>
          @empty
            <tr class="text-center">
               <td colspan="14">No data to show!</td>
            </tr>
          @endforelse
        
         
        </tbody>
    </table>
</div>

@endsection