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

    <div class="mt-3">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-4 form-search hidden pt-1">
                <form action="{{ route('search') }}" method="get" class="d-flex justify-content-between align-items-center">
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
            <div class="col-xs-12 col-sm-8 col-md-6">
                <div class="card bg-white mt-2">
                    <div class="card-header pt-3 pb-2 bg-white">
                        <h6 class="text-secondary">CLIENT: {{isset($customer)?strtoUpper($customer["org_name"])?strtoupper($customer["org_name"]):strtoupper($customer["fullname"]):''}}</h6>
                    </div>
                    <div class="card-body pt-3 pb-1 pe-4">
                        <ul>
                            <li class="text-secondary"><h6 class="d-flex justify-content-between align-items-center"> Account No: <span class="text-primary" id="acc_num">{{ isset($customer) ? $customer["account"] : '---' }}</span></h6></li>
                            <li class="text-secondary"><h6 class="d-flex justify-content-between align-items-center"> Meter IPS Bal: <span class="text-primary">{{ isset($customer) ?'Php '.toAccounting($customer["balance"]->billing_meter_ips) : '0.00' }}</span></h6></li>
                            <li class="text-secondary"><h6 class="d-flex justify-content-between align-items-center"> Outstanding Bal: <span class="text-primary">{{ isset($customer) ?'Php '.toAccounting($customer["balance"]->balance) : 'Php 0.00' }}</span></h6></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6">
                <div class="card bg-white mt-2">
                    <div class="card-header pt-3 pb-2 bg-white">
                        <h6 class="text-secondary">Previous Meter Reading</h6>
                    </div>
                    <div class="card-body pt-3 pb-1 pe-4">
                        <ul>
                            <li class="text-secondary">
                                <h6 class="d-flex justify-content-between align-items-center">Meter Reading: <span class="text-primary">{{ isset($customer) ? $customer["balance"]->reading_meter.' Cu. M' : '00 Cu. M' }}</span></h6>
                            </li>
                            <li class="text-secondary">
                                <h6 class="d-flex justify-content-between align-items-center">Consumption: <span class="text-primary">{{ isset($customer) ? $customer["balance"]->reading_consumption.' Cu. M' : '00 Cu. M' }}</span></h6>
                            </li>
                            <li class="text-secondary">
                                <h6 class="d-flex justify-content-between align-items-center">Amount: <span class="text-primary">Php {{ isset($customer) ? toAccounting($customer["balance"]->balance) : '0.00' }}</span></h6>
                            </li>
                            <li class="text-secondary">
                                <h6 class="d-flex justify-content-between align-items-center">Surcharge: <span class="text-primary">Php {{ isset($customer) ? toAccounting($customer["balance"]->billing_surcharge) : '0.00' }}</span></h6>
                            </li>
                            <li class="text-secondary">
                                <h6 class="d-flex justify-content-between align-items-center">Total : <span class="text-primary">Php {{ isset($customer) ? toAccounting($customer["balance"]->balance) : '0.00' }}</span></h6>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-xs-12 d-flex justify-content-md-start justify-content-center align-items-center mt-2">
                <button class="btn btn-primary d-flex justify-content-between align-items-center" data-bs-toggle='modal' data-bs-target='#ledgerSetupModal'><i data-feather="user-plus" class="feather-18 me-2"></i> New Meter Bill</button>
                <button class="btn btn-secondary d-flex justify-content-between align-items-center ms-1" data-bs-toggle='modal' data-bs-target='#tagSetupModal'><i data-feather="tag" class="feather-18 me-2"></i> Tag Consumer</button>
            </div>
        </div>
    </div>

    @include('field-personnel.templates.billingModal')
@endsection

@section('custom-js')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="{{ asset('assets/js/fieldMeterReading.js') }}" defer></script>

@endsection