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
                            <input type="text" class="text-bold form-control w-75 fae9d6 rounded-0 border-top-0 border-start-0 border-end-0 border-bottom border-secondary ml-3 pt-1 pb-1" value="{{ isset($customer) ? $customer["fullname"] : '' }}" readOnly>
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
                            <h3 class="h5 mb-2 mt-0 text-center"><strong>Balance as of {{ isset($customer) ? date('F j, Y') : '' }}</strong> - <span class="text-danger"><strong>{{ isset($customer) ?'Php '.toAccounting($customer["balance"]->balance) : '' }}</strong></span></h3>
                        </center>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive p-0">
                        <table class="table mb-0 border-0" style="min-width: 1200px;">
                            <thead>
                                <tr>
                                    <td class="pt-1 pb-3 text-center bg-white border-end border-secondary" rowspan="2"><strong>PERIOD </br>COVERED</strong></td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary" colspan="3"><strong>READING</strong></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary" colspan="4"><strong>BILLING</strong></td>
                                    <td class="pt-1 pb-4 text-center bg-white border-end border-secondary" rowspan="2"><strong>POSTED BY</strong></td>
                                    <td class="pt-2 pb-2 text-center eee border-bottom border-secondary" colspan="4"><strong>PAYMENT</strong></td>
                                </tr>
                                <tr>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary"><strong>DATE</strong></td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary"><strong>METER READING</strong></td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary"><strong>CONSUMPTION</strong></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><strong>AMOUNT</strong></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><strong>SURCHARGE</strong></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><strong>METER IPS</strong></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><strong>TOTAL</strong></td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary"><strong>OR NO</strong></td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary"><strong>DATE</strong></td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary"><strong>AMOUNT</strong></td>
                                    <td class="pt-2 pb-2 text-center eee border-bottom border-secondary"><strong>POSTED BY</strong></td>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php function toAccounting($num){ return number_format($num, 2, '.', ','); } ?>
                                @if(isset($customer))
                                @foreach($customer["transactions"] as $billing)
                                <tr>
                                    <td class="pt-2 pb-2 text-center bg-white border-end border-secondary">{{ $billing->period_covered }}</td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary">{{ \Carbon\Carbon::parse($billing->reading_date)->format('m-d-Y') }}</td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary">{{ $billing->reading_meter }}</td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary">{{ $billing->reading_consumption }}</td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary">{{ toAccounting($billing->billing_amount) }}</td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary">{{ toAccounting($billing->billing_surcharge) }}</td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary">{{ toAccounting($billing->billing_meter_ips) }}</td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary">{{ toAccounting($billing->billing_total) }}</td>
                                    <td class="pt-2 pb-2 text-center bg-white border-end border-secondary">John Clinton Doe</td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary">{{ $billing->payment_or_no }}</td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary">{{ $billing->payment_date }}</td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary">{{ !empty($billing->payment_amount) ? toAccounting($billing->payment_amount) : '' }}</td>
                                    <td class="pt-2 pb-2 text-center eee border-bottom border-secondary">{{ $billing->user->name }}</td>
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
<div class="modal modal-fluid fade" id="ledgerSetupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('admin.save-billing') }}" method="post" id="billing-form">
                @csrf
                <input type="hidden" name="connection_type" value="{{ isset($customer)?$customer['connection_type'] : ''}}">
                <input type="hidden" name="min_rates" value="{{ isset($rates) ? $rates['min_rate'] : '0'}}">
                <input type="hidden" name="excess_rate" value="{{ isset($rates) ? $rates['excess_rates'] : '0'}}">
                <input type="hidden" name="max_range" value="{{ isset($rates) ? $rates['max_range'] : '0'}}">
                <input type="hidden" name="or_num" value="{{ isset($customer) ? $customer['balance']->payment_or_no : ''}}">
                <input type="hidden" name="surcharge" value="{{ isset($surcharge) ? $surcharge : '0'}}">
                <input type="hidden" name="customer_id" value="{{ isset($customer) ? $customer['account'] : '' }}">

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
                            <input class="form-control" name="reading_date" id="reading_date" type="date">
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

                        <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-lg-2 mt-md-2 px-lg-1 pe-sm-1 ps-md-1 pe-1'>
                            <small class='text-muted'>Meter Reading</small>
                            <input class='form-control' type='number' min=0 id="reading_meter" name="reading_meter">
                        </div>

                        <div class='col-6 col-md-6 col-lg-4 col-xl-1 mt-2 mt-lg-2 mt-md-2 px-lg-0 ps-md-1 pe-md-0 ps-sm-0 ps-0'>
                            <small class='text-muted'>Consumption</small>
                            <input class='form-control' type='number' id="consumption" name="consumption" min=0 readOnly placeholder="0">
                        </div>
                        <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-2 px-lg-1 pe-sm-1 ps-md-1 pe-1'>
                            <small class='text-muted'>Amount</small>
                            <input class='form-control' type='number' id="amount" name="amount" min=0 readOnly placeholder="0.00">
                        </div>
                        <div class='col-6 col-md-6 col-lg-4 col-xl-1 mt-2 mt-md-2 px-lg-0 ps-md-1 pe-md-0 ps-sm-0 ps-0'>
                            <small class='text-muted'>Surcharge</small>
                            <input class='form-control' type='number' name="surcharge_amount" id="surcharge_amount" value='0.00' min=0 readonly>
                        </div>
                        <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-2 px-lg-1 pe-sm-1 ps-md-1 pe-1'>
                            <small class='text-muted'>Meter installment balance</small>
                            <input class='form-control' type='number' name="meter_ips" id="meter-ips" placeholder='0.00' min=0 value="{{ isset($customer) ? toAccounting($customer["balance"]->billing_meter_ips) : '0.00' }}">
                        </div>
                        <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-2 ps-lg-0 ps-md-1 pe-lg-1 ps-sm-0 pe-md-0 ps-0'>
                            <small class='text-muted'>Total</small>
                            <input class='form-control' type='number' id="total" name="total" placeholder='0.00' min=0 readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 pe-md-0 d-flex justify-content-start align-items-center">
                            <input name="override" id="override" type="checkbox">
                            <label class='text-muted ms-2'>Allow override period covered date ?</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i data-feather="x"></i> Close</button>
                    <button type="submit" class="btn btn-primary" id="save-billing" disabled><i data-feather="check"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom-js')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="{{ asset('assets/js/new_billing.js') }}" defer></script>


@endsection
