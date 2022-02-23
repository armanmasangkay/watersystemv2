@extends('layout.main-alt')

@section('title','Latest Bill')

@section('content')
<div class="my-2"><h2>Latest bill</h2></div>
<hr>
<div class="table-responsive">
    <table class="table-bordered w-100" style="border:1px solid #e4e8ec">
        <caption>Read by ({{$transaction->getNameOfBillCreator()}})</caption>
        <tr>
            <td class="p-4">
                <p class="text-gray">Period covered</p>
                <h4>{{$transaction->period_covered}}</h4>
            </td>

            {{-- test --}}
            <td class="p-4">
                <p class="text-gray">Reading Date (YYYY-MM-DD)</p>
                <h4>{{$transaction->reading_date}}</h4>
            </td>
        </tr>
        <tr>
            <td class="p-4">
                <p class="text-gray">Meter reading</p>
                <h4>{{$transaction->reading_meter}}</h4>
            </td>
            <td class="p-4">
                <p class="text-gray">Reading Consumption</p>
                <h4>{{$transaction->reading_consumption}}</h4>
            </td>
        </tr>
        <tr>
            <td class="p-4">      
                <p class="text-gray">Total</p>
                <h4>P {{$transaction->getBillingAmountFormatted()}}</h4>
            </td>
            <td class="p-4">
                <p class="text-gray">Balance</p>
                <h4>P {{$transaction->getOutstandingBalanceFormatted()}}</h4>
            </td>
        </tr>
       


    </table>
</div>



@endsection