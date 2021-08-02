@extends('field-personnel.layout.main')

@section('title', 'Meter Reading')

@section('content')
    <div class="mt-3">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-4 form-search hidden">
                <form action="" class="d-flex justify-content-between align-items-center">
                    <input type="text" class="form-control" placeholder="Account no. or name">
                    <button class="btn btn-primary ms-1 d-flex justify-content-between align-items-center" id="close"><i data-feather="search" class="feather-18 me-1"></i> Search</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6">
                <div class="card bg-white mt-2">
                    <div class="card-header pt-3 pb-2 bg-white">
                        <h6 class="text-secondary">CLIENT: NOBEGIN MASOB</h6>
                    </div>
                    <div class="card-body pt-3 pb-1">
                        <ul>
                            <li class="text-secondary"><h6> Account No: <span class="text-primary">2021-001-12</span></h6></li>
                            <li class="text-secondary"><h6> Meter IPS Bal: <span class="text-primary">Php 0.00</span></h6></li>
                            <li class="text-secondary"><h6> Outstanding Bal: <span class="text-primary">Php 0.00</span></h6></li>
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
                    <div class="card-body pt-3 pb-1">
                        <ul>
                            <li class="text-secondary">
                                <h6>Meter Reading: <span class="text-primary">1000</span></h6>
                            </li>
                            <li class="text-secondary">
                                <h6>Consumption: <span class="text-primary">10</span></h6>
                            </li>
                            <li class="text-secondary">
                                <h6>Amount: <span class="text-primary">Php 65.00</span></h6>
                            </li>
                            <li class="text-secondary">
                                <h6>Surcharge: <span class="text-primary">Php 0.00</span></h6>
                            </li>
                            <li class="text-secondary">
                                <h6>Total : <span class="text-primary">Php 65.00</span></h6>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-xs-12 d-flex justify-content-start align-items-center mt-2">
                <button class="btn btn-primary d-flex justify-content-between align-items-center" data-bs-toggle='modal' data-bs-target='#ledgerSetupModal'><i data-feather="user-plus" class="feather-18 me-2"></i> New Meter Bill</button>
                <!-- <button class="btn btn-secondary d-flex justify-content-between align-items-center ms-1"><i data-feather="file" class="feather-18 me-2"></i> Print Bill</button> -->
            </div>
        </div>
    </div>

    @include('field-personnel.templates.billingModal')
@endsection

@section('custom-js')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="{{ asset('assets/js/fieldMeterReading.js') }}" defer></script>

@endsection