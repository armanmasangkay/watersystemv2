@extends('layout.main')

@section('title', 'Register a Customer')

@section('content')

<div class="container{{ Request::is('admin/consumer-ledger/*') ? '-fluid px-4' : '' }} mt-5">
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
                            <button class="btn btn-success mt-2 ms-1 float-md-end" id="paymentBtn"><i data-feather="user-check" width="20"></i>&nbsp; Payment</button>
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
                            <input type="text" class="text-bold form-control w-75 fae9d6 rounded-0 border-top-0 border-start-0 border-end-0 border-bottom border-secondary ml-3 pt-1 pb-1" value="{{ isset($customer) ? $customer["account"] : '' }}" readOnly>
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
                            <h3 class="h5 mb-2 mt-0 text-center"><strong>Balance as of {{ isset($customer) ? date('F j, Y') : '' }}</strong> - <span class="text-danger" id="currentBalance"><strong>{{ isset($customer) ?'Php '.toAccounting($customer["balance"]->balance) : '' }}</strong></span></h3>
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
                                    <td class="pt-3 pb-3 text-center eee border-bottom border-secondary" colspan="4"><strong>PAYMENT</strong></td>
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
                                    <td class="pt-2 pb-2 text-center eee border-bottom border-secondary"><strong>POSTED BY</strong></td>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $amount = 0.00;
                                    $count = 0;
                                    function toAccounting($num){ return number_format($num, 2, '.', ','); } 
                                    function orNumbers($or) { return $or."/"; }
                                ?>
                                @if(isset($customer))
                                @foreach($customer["transactions"] as $billing)
                                <tr>
                                    <td class="pt-2 pb-2 text-center bg-white border-end border-secondary"><small>{{ $billing->period_covered }}</small></td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary"><small>{{ \Carbon\Carbon::parse($billing->reading_date)->format('m-d-Y') }}</small></td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary"><small>{{ $billing->reading_meter }}</small></td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary"><small>{{ $billing->reading_consumption }}</small></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><small>{{ toAccounting($billing->billing_amount) }}</small></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><small>{{ toAccounting($billing->billing_surcharge) }}</small></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><small>{{ toAccounting($billing->billing_meter_ips) }}</small></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><small>{{ toAccounting($billing->billing_total) }}</small></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><small>{{ toAccounting($billing->balance) }}</small></td>
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
                                                {{ "[". toAccounting($payment->payment_amount) . "]" }}
                                                @else
                                                {{ toAccounting($payment->payment_amount) }}
                                                @endif
                                            @endif
                                        @endforeach
                                        </small>
                                    </td>
                                    <td class="pt-2 pb-2 text-center eee border-bottom border-secondary">
                                        <small>
                                        @foreach($billing->payments as $payment)
                                            @if($payment->transaction_id == $billing->id)
                                                @if($count > 1)
                                                {{ "[". $payment->user->name."]" }}
                                                @else
                                                {{ $payment->user->name }}
                                                @endif
                                            @endif
                                        @endforeach
                                        </small>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="pt-3 pb-3 px-2 bg-light">
                            @if(isset($customer))
                            {{ $customer["transactions"]->links() }}
                            @else
                            <h5 class="text-center text-secondary">No records to display</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<<<<<<< HEAD
@include('templates.newBillingModal')
@include('templates.paymentModal')
=======
                <div class="modal-header">
                    <h5 class="modal-title text-muted" id="exampleModalLabel"><i data-feather="file"></i><strong>&nbsp; New Billing Setup</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <h5 class="text-muted">Previous Meter Reading</h5>
                    <div class="row mt-3">
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-sm-2 pe-md-1 pe-sm-1">
                            <label class='text-muted'>Meter reading</label>
                            <input class="form-control" id="meter-reading" name="meter-reading" type="number" placeholder="Meter reading" min=0 readOnly value="{{ isset($customer) ? $customer["balance"]->reading_meter : '' }}">
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-sm-2 ps-md-0 pe-md-0 ps-sm-1">
                            <label class='text-muted'>Balance</label>
                            <input class="form-control" id="cur_balance" name="cur_balance" type="text" placeholder="Meter reading" min=0 readonly value="{{ isset($customer) ? toAccounting($customer["balance"]->balance) : '0.00' }}">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-4 pe-md-0">
                            <label class='text-muted'>Reading date</label>
                            <input type="text" class="form-control" name="date" value="{{ isset($customer) ? \Carbon\Carbon::parse($customer['balance']->reading_date)->format('F d, Y') : '' }}" readonly>
                        </div>
                    </div>

                    <h5 class="text-muted mt-4">Current Meter Reading</h5>
                
                    <div class="row mt-3">
                        <div class="col-md-4 pe-md-0">
                            <label class='text-muted'>Reading date</label>
                            <input class="form-control" name="reading_date" id="reading_date" type="date" 
                            min="{{\Carbon\Carbon::parse($last_date)->addMonth()->format('Y-m-01')}}" 
                            max="{{\Carbon\Carbon::parse($last_date)->addMonth()->endOfMonth()->format('Y-m-d')}}">
    
                        </div>
                    </div>
                   
                    
                    <div class='row px-md-2 mb-2 mt-2'>
                        <div class='col-6 col-md-3 col-lg-2 col-xl-1 mt-2 pe-md-1 ps-md-1 ps-lg-1 pe-sm-1 pe-1'>
                            <small class='text-primary'>{{ isset($last_date) ? \Carbon\Carbon::parse($last_date)->format('M, Y') : '' }}</small>
                            <select name='current_month' id='current-month' class='form-select' disabled>
                                @if(isset($customer))
                                @for($i = 1; $i <= \Carbon\Carbon::parse($last_date)->endOfMonth()->format('d'); $i++)
                                <option value="{{ \Carbon\Carbon::parse($last_date)->format('M '.($i < 10 ? '0'.$i : $i)) }}" {{ \Carbon\Carbon::parse($last_date)->format('d') == $i ? 'selected' : '' }}>{{ $i < 10 ? '0'.$i : $i }}</option>
                                @endfor
                                @endif
                            </select>

                        </div>
                        <div class='col-6 col-md-3 col-lg-2 col-xl-1 mt-2 ps-md-0 pe-md-0 ps-sm-0 ps-0'>
                            <small class='text-primary'>{{ isset($customer) ? \Carbon\Carbon::parse($last_date)->addMonths(1)->format('M, Y') : '' }}</small>
                            <select name='next_month' id='next-month' class='form-select' disabled>
                                @if(isset($customer))
                                @for($i = 1; $i <=  \Carbon\Carbon::parse($last_date)->addMonths(1)->endOfMonth()->format('d'); $i++)
                                <option value="{{ \Carbon\Carbon::parse($last_date)->addMonths(1)->format('M '.($i < 10 ? '0'.$i : $i).', Y') }}" {{ \Carbon\Carbon::parse($last_date)->format('d') == $i ? 'selected' : '' }}>{{ $i < 10 ? '0'.$i : $i }}</option>
                                @endfor
                                @endif
                            </select>
                        </div>
>>>>>>> a11ccaab8b72be63cde5a736cd26d68a06a80318

@endsection

@section('custom-js')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="{{ asset('assets/js/new_billing.js') }}" defer></script>
<script src="{{ asset('assets/js/payments.js') }}" defer></script>

@endsection
