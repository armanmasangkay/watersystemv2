@extends('layout.main')

@section('title', 'Register a Customer')

@section('content')

<div class="container{{ Request::is('admin/consumer-ledger*') ? '-fluid px-4' : '' }} mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-secondary">
                <div class="card-header border-secondary px-2 pb-1 pt-2 bg-light">
                    <div class="row">
                        <div class="col-md-6 pe-md-0">
                            @include('templates.form-search-account')
                        </div>
                        @if(isset($customer))
                        <div class="col-md-6">
                            @if($customer['balance'] != null)
                            <button class="btn btn-success mt-2 ms-1 float-md-end" id="paymentBtn"><i data-feather="user-check" width="20"></i>&nbsp; Payment</button>
                            @endif
                            <button class="btn btn-primary mt-2 float-md-end" data-bs-toggle='modal' data-bs-target='#ledgerSetupModal'><i data-feather="user-plus" width="20"></i>&nbsp; New Water Bill</button>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-header border-secondary px-2 pb-0 f70b7e9">
                    <h3 class="h4 mb-3 mt-2 text-black text-center"><strong>MACROHON MUNICIPAL WATERWORKS</strong></h3>
                </div>
                <div class="card-header border-secondary px-2 pb-0 f94c7eb">
                    <h3 class="h5 mb-2 mt-0 text-center"><strong>CONSUMER LEDGER CARD</strong></h3>
                </div>

                <div class="card-header border-secondary px-4 pb-2 pt-2 bg-light">
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between align-items-center pe-5"><span><strong>Name:</strong></span>&nbsp;&nbsp;
                            <input type="text" class="text-bold form-control w-75 fae9d6 rounded-0 border-top-0 border-start-0 border-end-0 border-bottom border-secondary ml-3 pt-1 pb-1"
                            value="{{isset($customer)?$customer["org_name"]?$customer["org_name"]:$customer["fullname"]:''}}"
                            readOnly>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between align-items-center pe-5"><span><strong>Account No:</strong></span>&nbsp;&nbsp;
                            <input type="text" class="text-bold form-control w-75 fae9d6 rounded-0 border-top-0 border-start-0 border-end-0 border-bottom border-secondary ml-3 pt-1 pb-1" id="account_number" value="{{ isset($customer) ? $customer["account"] : '' }}" readOnly>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-6 d-flex justify-content-between align-items-center pe-5"><span><strong>Address:</strong></span>&nbsp;&nbsp;
                            <input type="text" class="text-bold form-control w-75 fae9d6 rounded-0 border-top-0 border-start-0 border-end-0 border-bottom border-secondary ml-3 pt-1 pb-1" value="{{ isset($customer) ? $customer["address"] : '' }}" readOnly>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between align-items-center pe-5"><span><strong>Connection Type:</strong></span>&nbsp;&nbsp;
                            <input type="text" name="balance" class="text-bold form-control w-75 fae9d6 rounded-0 border-top-0 border-start-0 border-end-0 border-bottom border-secondary ml-3 pt-1 pb-1" value="{{ isset($customer) ? Str::title($customer["connection_type"]) : '' }}" readOnly>
                        </div>
                    </div>
                </div>
                <div class="card-header border-secondary px-4 pb-1 pt-2 f94c7eb">
                    <div class="row mt-1">
                        <center>
                            <h3 class="h5 mb-2 mt-0 text-center"><strong>Balance as of {{ isset($customer) ? date('F j, Y') : '' }}</strong> - <span class="text-danger" id="currentBalance"><strong>{{ isset($customer) ? ($customer['balance'] != null  ? ('Php '. \App\Classes\Facades\NumberHelper::toAccounting($customer["balance"]->balance)) : 'Php 0.00') : 'Php 0.00' }}</strong></span></h3>
                        </center>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive p-0">
                        <table class="table mb-0 border-0" style="min-width: 1200px;">
                            <thead>
                                <tr>
                                    <td class="pt-0 pb-4 text-center bg-white border-end border-secondary" rowspan="2"><strong>PERIOD </br>COVERED</strong></td>
                                    <td class="pt-3 pb-3 text-center f0f0f0 border-end border-secondary" colspan="3"><strong>READING</strong></td>
                                    <td class="pt-3 pb-3 text-center f8d6b0 border-end border-secondary" colspan="6"><strong>BILLING</strong></td>
                                    <td class="pt-3 pb-3 text-center eee border-bottom border-end border-secondary" colspan="4"><strong>PAYMENT</strong></td>
                                    <td class="pt-0 pb-4 text-center bg-white border-bottom border-secondary" rowspan="2"><strong>EDIT </br>BILLING</strong></td>
                                </tr>
                                <tr>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary"><strong>DATE</strong></td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary"><strong>MTR. READING</strong></td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary"><strong>CONSUMP</strong></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><strong>AMOUNT</strong></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><strong>SURCHARGE</strong></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><strong>METER IPS</strong></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><strong>TOTAL</strong></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><strong>BAL.</strong></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><strong>POSTED BY</strong></td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary"><strong>OR NUMBER</strong></td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary"><strong>PAYMENT DATE</strong></td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary"><strong>AMOUNT</strong></td>
                                    <td class="pt-2 pb-2 text-center eee border-bottom border-end border-secondary"><strong>POSTED BY</strong></td>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $amount = 0.00;
                                    $count = 0;


                                ?>
                                @if(isset($customer["transactions"]))
                                @foreach($customer["transactions"] as $billing)
                                <tr>
                                    <td id="tdpc-{{ $billing->period_covered }}" class="pt-2 pb-2 text-center bg-white border-end border-secondary"><small>{{ $billing->period_covered }}</small></td>
                                    <td id="tdrd-{{ $billing->period_covered }}" class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary"><small>{{ \Carbon\Carbon::parse($billing->reading_date)->format('m-d-Y') }}</small></td>
                                    <td id="tdrm-{{ $billing->period_covered }}" class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary"><small>{{ $billing->reading_meter }}</small></td>
                                    <td id="tdrc-{{ $billing->period_covered }}" class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary"><small>{{ $billing->reading_consumption }}</small></td>
                                    <td id="tdbs-{{ $billing->period_covered }}" class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><small>{{ \App\Classes\Facades\NumberHelper::toAccounting($billing->billing_amount) }}</small></td>
                                    <td id="tdba-{{ $billing->period_covered }}" class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><small>{{ \App\Classes\Facades\NumberHelper::toAccounting($billing->billing_surcharge) }}</small></td>
                                    <td id="tdmb-{{ $billing->period_covered }}" class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><small>{{ \App\Classes\Facades\NumberHelper::toAccounting($billing->billing_meter_ips) }}</small></td>
                                    <td id="tdbt-{{ $billing->period_covered }}" class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><small>{{ \App\Classes\Facades\NumberHelper::toAccounting($billing->billing_total) }}</small></td>
                                    <td id="tdbb-{{ $billing->period_covered }}" class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><small>{{ \App\Classes\Facades\NumberHelper::toAccounting($billing->balance) }}</small></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><small>{{ $billing->user->name }}</small></td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary">
                                        <small>
                                        @foreach($billing->payments as $payment)
                                            @if($payment->transaction_id == $billing->id)
                                                <?php $count += 1; ?>
                                                @if($count >= 1)
                                                {{ "[". $payment->or_no . "]" }}
                                                @else
                                                {{ $payment->or_no }}
                                                @endif
                                            @endif
                                        @endforeach
                                        </small>
                                    </td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary">
                                        <small>
                                        @foreach($billing->payments as $payment)
                                            @if($payment->transaction_id == $billing->id)
                                                @if($count > 1)
                                                {{ "[". \Carbon\Carbon::parse($payment->payment_date)->format('F d, Y') . "]" }}
                                                @else
                                                {{ \Carbon\Carbon::parse($payment->payment_date)->format('F d, Y') }}
                                                @endif
                                            @endif
                                        @endforeach
                                        </small>
                                    </td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary">
                                        <small>
                                        @foreach($billing->payments as $payment)
                                            @if($payment->transaction_id == $billing->id)
                                                @if($count > 1)
                                                {{ "[". \App\Classes\Facades\NumberHelper::toAccounting($payment->payment_amount) . "]" }}
                                                @else
                                                {{ \App\Classes\Facades\NumberHelper::toAccounting($payment->payment_amount) }}
                                                @endif
                                            @endif
                                        @endforeach
                                        </small>
                                    </td>
                                    <td class="pt-2 pb-2 text-center eee border-bottom border-end border-secondary">
                                        <small>
                                        @foreach($billing->payments as $payment)
                                            @if($payment->transaction_id == $billing->id)
                                                @if($count > 1)
                                                {{ "[". $payment->user->name."]" }}
                                                <?php $count++; ?>
                                                @else
                                                {{ $payment->user->name }}
                                                <?php $count = 0; ?>
                                                @endif
                                            @endif
                                        @endforeach
                                        </small>
                                    </td>
                                    <td class="pt-2 pb-2 text-center bg-white border-bottom border-secondary">
                                        @if($billing->payments->count() == 0)
                                            <a href="#" class="text-primary" data-id="{{ $billing->id }}" id="edit"><i data-feather="edit-3" class="feather-18 me-1"></i> Edit</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="{{ (isset($customer['transactions']) && count($customer['transactions']) > 0) ? 'pt-3 pb-2' : 'pt-2 pb-1' }} px-2 bg-light">
                            <div class="{{ (isset($customer['transactions']) && count($customer['transactions']) > 0) ? 'd-flex justify-content-between' : 'float-center' }}">
                                <div class="{{ (isset($customer['transactions']) && count($customer['transactions']) > 0) ? 'float-left' : 'float-center' }}">
                                    @if(isset($customer['transactions']) && count($customer["transactions"]) > 0)
                                    {{ $customer["transactions"]->links() }}
                                    @else
                                    <h6 class="text-center text-secondary">No records to display</h6>
                                    @endif
                                </div>
                                @if(isset($customer['transactions']) && count($customer["transactions"]) > 0)
                                <div class="float-md-end mb-1">
                                    @if(isset($customer))
                                        <a href="{{route('admin.ledger.export',['account_number'=>$customer['account']])}}" class="btn btn-secondary py-2"><i data-feather="download" class="feather-20 me-1 pb-1"></i> Export Ledger</a>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($customer))
    @include('templates.newBillingModal')
    @include('templates.paymentModal')
    @include('templates.editBillingModal')
@endif

@endsection

@section('custom-js')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="{{ asset('assets/js/new_billing.js') }}" defer></script>
<script src="{{ asset('assets/js/payments.js') }}" defer></script>
<script src="{{ asset('assets/js/edit_billing.js') }}" defer></script>

@endsection
