@extends('field-personnel.layout.main')

@section('title', 'Meter Reading')

@section('content')

    <?php
        // dd(isset($customer));
        $amount = 0.00;
        $count = 0;
        function toAccounting($num){ return number_format($num, 2, '.', ','); }
        function orNumbers($or) { return $or."/"; }
    ?>

    <div class="mt-3" id="reading">
        <div class="row">
            <div class="col-12 col-sm-8 col-md-6 col-lg-6 form-search hidden pt-1">
                <form action="{{ route('admin.reader.search') }}" method="get" class="d-flex justify-content-between align-items-center mb-lg-0">
                    <input type="text" class="form-control" name="account_number" placeholder="Account no. or name">
                    <button class="btn btn-primary ms-1 d-flex justify-content-between align-items-center" id="close"><i data-feather="search" class="feather-18 me-1"></i> Search</button>
                </form>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger pb-0">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-12 col-sm-8 col-md-6">
                @if(isset($customer))
                <h6 class="text-secondary ps-1 d-block d-lg-none pt-2" style="font-size: 17px !important;"><strong>CLIENT : {{isset($customer)?strtoUpper($customer["org_name"])?strtoupper($customer["org_name"]):strtoupper($customer["fullname"]):''}}</strong></h6>
                <h6 class="text-secondary ps-1 d-block d-lg-none pb-2" style="font-size: 15px !important;"><strong>ACCOUNT NO : <span class="text-primary" id="customer_account">{{ isset($customer) ? $customer["account"] : '' }}</span></strong></h6>
                <h6 class="text-secondary ps-1 d-block d-lg-none pb-2" style="font-size: 15px !important;"><strong>SERIAL NUMBER: <span class="text-primary" id="customer_account">{{ isset($customer) ? $customer["serial_number"] : '' }}</span></strong></h6>
                @endif
                <div class="card bg-white mt-md-2">
                    <div class="card-header pt-3 pb-2 bg-white {{ isset($customer) ? 'd-none d-lg-block' : '' }} ">
                        <h3 class="text-muted"><strong>Meter Reading </strong></h3>
                    </div>
                    <div class="card-body pt-3 pb-1 pe-4">
                        <ul>
                            <li class="text-secondary {{ isset($customer) ? 'd-none d-lg-block' : '' }} "><h6 class="d-flex justify-content-between align-items-center"> Client Name: <span class="text-primary">{{isset($customer)?strtoUpper($customer["org_name"])?strtoupper($customer["org_name"]):strtoupper($customer["fullname"]):''}}</span></h6></li>
                            <li class="text-secondary {{ isset($customer) ? 'd-none d-lg-block' : '' }} "><h6 class="d-flex justify-content-between align-items-center"> Account No: <span class="text-primary" id="acc_num">{{ isset($customer) ? $customer["account"] : '---' }}</span></h6></li>
                            <li class="text-secondary"><h6 class="d-flex justify-content-between align-items-center"> Meter IPS Bal: <span class="text-primary">{{ isset($customer) ?'Php '.(isset($customer["balance"]->billing_meter_ips) ? toAccounting($customer["balance"]->billing_meter_ips) : '0.00') : '0.00' }}</span></h6></li>
                            <li class="text-secondary"><h6 class="d-flex justify-content-between align-items-center"> Current Balance: <span class="text-primary">{{ isset($customer) ?'Php '.(isset($customer["balance"]->balance) ? toAccounting($customer["balance"]->balance) : '0.00') : 'Php 0.00' }}</span></h6></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @if(!isset($customer))
        <div class="card px-3 mt-2">
            <p class="text-info pt-3 info-txt"><i data-feather="info" class="feather-18 mb-1"></i> Note: Search a customer to show account information and add a bill.</p>
            <div class="row mt-1 parent mb-3 d-block d-lg-none" id="parent">
                <div class="col-xs-12 d-flex justify-content-start align-items-center mt-2">
                    <button type="button" id="search" class="search btn btn-primary d-flex justify-content-between align-items-center"><i data-feather="search" class="feather-18 me-2"></i> Search Customer</button>
                </div>
            </div>
        </div>
        @endif
        @if(isset($customer))
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6">
                @if(isset($customer))
                <h6 class="text-secondary ps-1 d-block d-lg-none pt-3 pb-2" style="font-size: 17px !important;"><strong>Previous Meter Reading</strong></h6>
                @endif
                <div class="card bg-white mt-2">
                    <div class="card-header pt-3 pb-2 bg-white {{ isset($customer) ? 'd-none d-lg-block' : '' }} ">
                        <h6 class="text-secondary">Previous Meter Reading</h6>
                    </div>
                    <div class="card-body pt-3 pb-1 pe-4">
                        <ul>
                            <li class="text-secondary">
                                <h6 class="d-flex justify-content-between align-items-center">Meter Reading: <span class="text-primary">{{ isset($customer) ? (isset($customer["balance"]->reading_meter) ? $customer["balance"]->reading_meter : '0.00').' Cu. M' : '00 Cu. M' }}</span></h6>
                            </li>
                            <li class="text-secondary">
                                <h6 class="d-flex justify-content-between align-items-center">Consumption: <span class="text-primary">{{ isset($customer) ? (isset($customer["balance"]->reading_consumption) ? $customer["balance"]->reading_consumption : '0.00').' Cu. M' : '00 Cu. M' }}</span></h6>
                            </li>
                            <li class="text-secondary">
                                <h6 class="d-flex justify-content-between align-items-center">Amount: <span class="text-primary">Php {{ isset($customer) ? (isset($customer["balance"]->balance) ? toAccounting($customer["balance"]->balance) : '0.00') : '0.00' }}</span></h6>
                            </li>
                            <li class="text-secondary">
                                <h6 class="d-flex justify-content-between align-items-center">Surcharge: <span class="text-primary">Php {{ isset($customer) ? (isset($customer["balance"]->billing_surcharge) ? toAccounting($customer["balance"]->billing_surcharge) : '0.00') : '0.00' }}</span></h6>
                            </li>
                            <li class="text-secondary">
                                <h6 class="d-flex justify-content-between align-items-center">Total Amount : <span class="text-primary">Php {{ isset($customer) ? (isset($customer["balance"]->balance) ? toAccounting($customer["balance"]->balance) : '0.00') : '0.00' }}</span></h6>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(isset($customer))
        <div class="row mt-3">
            <div class="col-xs-12 d-flex justify-content-md-start justify-content-center align-items-center mt-2">
                <button class="btn btn-primary d-flex justify-content-between align-items-center" data-bs-toggle='modal' data-bs-target='#ledgerSetupModal'><i data-feather="user-plus" class="feather-18 me-2"></i> New Meter Bill</button>
                <button class="btn btn-danger d-flex justify-content-between align-items-center ms-1" data-bs-toggle='modal' data-bs-target='#tagSetupModal'><i data-feather="tag" class="feather-18 me-2"></i> Tag Consumer</button>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 d-flex justify-content-md-start justify-content-center align-items-center mt-2">
                <button class="btn btn-success d-flex justify-content-between align-items-center ms-1" id="print-bill" data-enable="0"><i data-feather="printer" class="feather-18 me-2"></i> Print Bill</button>
                <button class="btn btn-secondary d-flex justify-content-between align-items-center ms-1" id="reload" data-enable="0"><i data-feather="rotate-cw" class="feather-18 me-2"></i> Reload Page</button>
            </div>
        </div>
        @endif
    </div>

    <div id="print" style="display: none;">
        <div class="row">
            <div class="container p-1">
                <div class="col-md-4 offset-md-4">
                    <table class="table">
                        <tr>
                            <td colspan="3" class="border-bottom-0 pt-1 ps-3">
                                <img src="{{ asset('assets/img/logo-macrohon_black.png') }}" class="m-0 d-inline-block ms-2" alt="logo">
                                <div class="text-left ps-0  d-inline-block">
                                    <span style="font-size: 10px;">Municipality of Macrohon</span>
                                    <h6 class="mb-0"><strong>MACROHON WATER</strong></h6>
                                    <small style="font-size: 9px;">Macrohon Municipal Waterworks System</small><br>
                                    <small style="font-size: 7px;">San Vicente (Poblacion), Macrohon, Southern Leyte</small><br>
                                    <small style="font-size: 8px;">Contact : (053) 589 0285/09173129873</small><br>
                                    <small style="font-size: 8px;">Email : macrohon@outlook.ph</small>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="ps-5 pt-2 border-bottom-0"><h6 class="me-3">STATEMENT OF ACCOUNT</h6></td>
                        </tr>
                        <tr>
                            <td  colspan="3" class="text-left py-0 border-bottom-0">-----------------------------------------</td>
                        </tr>
                        <tr>
                            <td class="py-0 ps-3 border-bottom-0 i-data">&nbsp;Account No.</td>
                            <td colspan="2" class="py-0 border-bottom-0 i-data">: <span>{{ isset($customer) ? $customer["account"] : '' }}</span></td>
                        </tr>
                        <tr>
                            <td class="py-0 ps-3 border-bottom-0 i-data">&nbsp;Name</td>
                            <td colspan="2" class="py-0 border-bottom-0 i-data">: <span>{{isset($customer)?strtoUpper($customer["org_name"])?strtoupper($customer["org_name"]):strtoupper($customer["fullname"]):''}}</span></td>
                        </tr>
                        <tr>
                            <td class="py-0 ps-3 border-bottom-0 i-data">&nbsp;Address</td>
                            <td colspan="2" class="py-0 border-bottom-0 i-data">: <span>{{ isset($customer) ? $customer["address"] : '' }}</span></td>
                        </tr>
                        <tr>
                            <td class="py-0 ps-3 border-bottom-0 i-data">&nbsp;Classification</td>
                            <td colspan="2" class="py-0 border-bottom-0 i-data">: <span>{{ isset($customer) ? ucwords($customer["connection_type"]) : '' }}</span></td>
                        </tr>
                        <tr>
                            <td class="py-0 ps-3 border-bottom-0 i-data">&nbsp;Meter S/N</td>
                            <td colspan="2" class="py-0 border-bottom-0 i-data">: <span>1001</span></td>
                        </tr>
                        -<tr>
                            <td  colspan="3" class="text-left py-0 border-bottom-0">-----------------------------------------</td>
                        </tr>
                        <tr>
                            <td class="py-0 ps-3 border-bottom-0 i-data">&nbsp;Bill No.</td>
                            <td colspan="2" class="py-0 border-bottom-0 i-data">: <span>{{ isset($customer) ? (isset($customer["balance"]->balance) ? $customer["balance"]->id + 1 : '') : '' }}</span></td>
                        </tr>
                        <tr>
                            <td class="py-0 ps-3 border-bottom-0 i-data">&nbsp;Billing Month</td>
                            <td colspan="2" class="py-0 border-bottom-0 i-data">: <span>{{ isset($last_date) ? date('M Y', strtotime('now')) : '' }}</span></td>
                        </tr>
                        <tr>
                            <td class="py-0 ps-3 border-bottom-0 i-data">&nbsp;Billing Period</td>
                            <td colspan="2" class="py-0 border-bottom-0 i-data">: <span class="me-3 pe-3">{{ isset($last_date) ? \Carbon\Carbon::parse($last_date)->format('M d') : '' }}-{{ isset($last_date) ? \Carbon\Carbon::parse($last_date)->addMonths(1)->format('M d, Y') : '' }}</span></td>
                        </tr>
                        <tr>
                            <td class="py-0 ps-3 border-bottom-0 i-data">&nbsp;Due Date</td>
                            <td colspan="2" class="py-0 border-bottom-0 i-data">: <span>{{ isset($last_date) ? \Carbon\Carbon::parse($last_date)->addMonths(1)->addDays(-1)->format('M d') : '' }}</span></td>
                        </tr>
                        <tr>
                            <td  colspan="3" class="text-left py-0 border-bottom-0">-----------------------------------------</td>
                        </tr>
                        <tr>
                            <td class="py-0 ps-3 border-bottom-0 i-data">&nbsp;Current Reading</td>
                            <td colspan="2" class="py-0 border-bottom-0 text-right i-data">: <span id="mtr_cur">0 Cu.M</span></td>
                        </tr>
                        <tr>
                            <td class="py-0 ps-3 border-bottom-0 i-data">&nbsp;Previous Reading</td>
                            <td colspan="2" class="py-0 border-bottom-0 text-right i-data">: <span>{{ isset($customer) ? (isset($customer["balance"]->reading_meter) ? $customer["balance"]->reading_meter : 0.00).' Cu. M' : '00 Cu. M' }}</span></td>
                        </tr>
                        <tr>
                            <td class="py-0 ps-3 border-bottom-0 i-data">&nbsp;Cu.M Consumed</td>
                            <td colspan="2" class="py-0 border-bottom-0 i-data">: <span id="mtr_con"></span></td>
                        </tr>
                        <tr>
                            <td  colspan="3" class="text-left py-0 border-bottom-0">-----------------------------------------</td>
                        </tr>
                        <tr>
                            <td class="pb-1 ps-3 border-bottom-0 i-data">&nbsp;CURRENT BILL</td>
                            <td colspan="2" class="pb-1 border-bottom-0 pe-3 i-data pe-4" align="left">
                                <span class="pe-3 pb-2" style="font-size: 14px; border-bottom: 1px solid #000;" id="mtr_cur_bill"><strong> Php 0.00</strong>&nbsp;&nbsp;</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="pt-3 pb-0 ps-3 border-bottom-0 i-data">&nbsp;Bal. from Last Bill</td>
                            <td colspan="2" class="pt-3 pb-0 border-bottom-0 pe-3 i-data pe-4" align="left">Php<span> {{ isset($customer) ? (isset($customer["balance"]->balance) ? toAccounting($customer["balance"]->balance) : '0.00') : '0.00' }}</span></td>
                        </tr>
                        <tr>
                            <td class="py-0 ps-3 border-bottom-0 i-data">&nbsp;Surcharge (10%)</td>
                            <td colspan="2" class="py-0 border-bottom-0 pe-3 i-data pe-4" align="left"><span class="invisible">Php</span> <span class="align-right" id="mtr_sur">0.00</span></td>
                        </tr>
                        <tr>
                            <td class="py-0 ps-3 border-bottom-0 i-data">&nbsp;Meter Installment</td>
                            <td colspan="2" class="pt-0 pb-2 border-bottom-0 pe-3 i-data pe-4" align="left">
                                <span class="pe-4 pb-2" style="border-bottom: 1px solid #000;">
                                    <span class="invisible">Php</span> <span class="pe-3">{{ isset($customer) ? (isset($customer["balance"]->meter_ips) ? toAccounting($customer["balance"]->meter_ips) : '0.00') : '0.00' }}</span>&nbsp;
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="pt-3 ps-3 border-bottom-0 i-data"><strong>&nbsp;TOTAL DUE</strong></td>
                            <td colspan="2" class="pt-3 border-bottom-0 pe-3 i-data" align="left">
                                <span class="w-50 pb-2" style="border-bottom: 3px solid #000;">
                                    <span class="pe-4 pb-2 me-0" style="font-size: 14px;" id="mtr_due"><strong>Php 0.00</strong></span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td  colspan="3" class="text-left pt-2 pb-0 border-bottom-0">-----------------------------------------</td>
                        </tr>
                        <tr>
                            <td class="pt-2 ps-3 border-bottom-0 reader"><small style="font-size: 11px;">&nbsp;Meter Reader</small></td>
                            <td colspan="2" class="pt-1 border-bottom-0 reader">: <small style="font-size: 11px;">Nobegin Masob</small></td>
                        </tr>
                        <tr>
                            <td class="pt-1 ps-3 border-bottom-0 reader"><small style="font-size: 11px;">&nbsp;DateTime Read</small></td>
                            <td colspan="2" class="py-0 border-bottom-0 pe-3 reader">: <small style="font-size: 11px;">{{ date('Y M d, h:m a', strtotime('now')) }}</small></td>
                        </tr>
                        <tr>
                            <td  colspan="3" class="text-left py-0 border-bottom-0">-----------------------------------------</td>
                        </tr>
                        <tr>
                            <td  colspan="3" class="text-left ps-5 py-3 border-bottom-0"><strong>IMPORTANT REMINDERS</strong></td>
                        </tr>
                        <tr>
                            <td  colspan="3" class="text-left border-bottom-0 py-1 px-3 info-rem"><small style="font-size: 12px;">&nbsp;• A surcharge at 10% of the amount due is <br>
                                &nbsp;&nbsp;added if bill is paid after due date.</small>
                            </td>
                        </tr>
                        <tr>
                            <td  colspan="3" class="text-left border-bottom-0 py-1 px-3 info-rem"><small style="font-size: 12px;">&nbsp;• Disconnection shall follow without further <br>
                                &nbsp;&nbsp;notice if no payment has been made within <br>&nbsp;&nbsp;15 days after due date.</small>
                            </td>
                        </tr>
                        <tr>
                            <td  colspan="3" class="text-left border-bottom-0 py-1 px-3 info-rem"><small style="font-size: 12px;">&nbsp;• Please report immediately any leaking <br>
                                &nbsp;&nbsp;and/or defective water meter to avoid <br>&nbsp;&nbsp;incurring high water charges.</small>
                            </td>
                        </tr>
                        <tr>
                            <td  colspan="3" class="text-left border-bottom-0 py-1 px-3 info-rem"><small style="font-size: 12px;">&nbsp;•  For account reconciliations, kindly ask for <br>
                                &nbsp;&nbsp;assistance through our contact number <br>
                                &nbsp;&nbsp;above. You may also visit us at the Ground <br>&nbsp;&nbsp;Floor of the Municipal Hall</small>
                            </td>
                        </tr>
                        <tr>
                            <td  colspan="3" class="text-left pt-3 border-bottom-0">-----------------------------------------</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-left pt-1 px-4 border-bottom-0"><svg id="barcode" width="200px"></svg></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('field-personnel.templates.billingModal')
    @include('field-personnel.templates.tagModal')

@endsection

@section('custom-js')

<script src="{{ asset('assets/js/form-search-animation.js') }}" defer></script>
<script src="{{ asset('assets/js/fieldMeterReading.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.4/dist/JsBarcode.all.min.js"></script>
<script>
    $(document).ready(function(){
        JsBarcode("#barcode", $('#customer_account').text(), {
            height: 60,
            displayValue: false,
            background: 'transparent',
            margin: 0,
            lineColor: '#000000'
        });
    })
</script>

@endsection
