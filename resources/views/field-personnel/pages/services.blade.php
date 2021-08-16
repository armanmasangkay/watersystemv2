@extends('field-personnel.layout.main')

@section('title', 'Meter Services')

@section('content')
    <div class="mt-3">
        <div class="row">
            <div class="col-12 col-sm-8 col-md-6 col-lg-6 form-search d-lg-block d-md-none hidden pt-1">
                <form action="{{ route('services-search-customer') }}" method="get" class="d-flex justify-content-between align-items-center mb-lg-0">
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
        @if(isset($customer))
        <h6 class="text-secondary ps-1 d-block d-lg-none pt-2" style="font-size: 17px !important;"><strong>CLIENT : {{isset($customer)?strtoUpper($customer["org_name"])?strtoupper($customer["org_name"]):strtoupper($customer["fullname"]):''}}</strong></h6>
        <h6 class="text-secondary ps-1 d-block d-lg-none pb-2" style="font-size: 15px !important;"><strong>ACCOUNT NO : <span class="text-primary">{{ isset($customer) ? $customer["account"] : '' }}</span></strong></h6>
        @endif
        <div class="row">
            <div class="col-12 col-sm-8 col-md-6">
                <div class="card bg-white mt-md-2">
                    <div class="card-header pt-3 pb-2 bg-white d-none d-lg-block">
                        <h6 class="text-secondary d-flex justify-content-start align-items-center"><span>CLIENT &nbsp;:</span> <span class="text-primary ms-2">{{isset($customer)?strtoUpper($customer["org_name"])?strtoupper($customer["org_name"]):strtoupper($customer["fullname"]):''}}</span></h6>
                        <h6 class="text-secondary d-flex justify-content-start align-items-center"><span>ACC. # &nbsp; :</span> <span class="text-primary ms-2" id="acc_num">{{ isset($customer) ? $customer["account"] : '' }}</span></h6>
                    </div>
                    <div class="card-body pt-3 pb-2 px-3">
                        <form action="">
                            <p class="text-danger pt-1">Reminder: Fields with (*) is required.</p>
                            <h3 class="text-muted mt-4"><strong>Water Works Services </strong></h3>
                            <div class="row mt-4 mb-2 ps-4">
                                <p class="mb-0">Select service(s) <span class="text-danger">*</span></p>
                                <div class="ms-4">
                                    <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="checkbox" name="" id="" class="me-2 mt-1">Broken Meter</h6>
                                    <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="checkbox" name="" id="" class="me-2 mt-1">Transfer Meter Location</h6>
                                    <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="checkbox" name="" id="" class="me-2 mt-1">Transfer of Ownership</h6>
                                    <!-- <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="checkbox" name="" id="" class="me-2 mt-1"></h6>
                                    <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="checkbox" name="" id="" class="me-2 mt-1"></h6> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if(!isset($customer))
                <div class="card px-3 mt-2">
                    <p class="text-info pt-3 info-txt"><i data-feather="info" class="feather-18 mb-1"></i> Note: Search customer then select service(s) to process your request</p>
                    <div class="row mt-1 parent mb-3 d-block d-lg-none" id="parent">
                        <div class="col-xs-12 d-flex justify-content-start align-items-center mt-2">
                            <button type="button" id="search" class="search btn btn-primary d-flex justify-content-between align-items-center"><i data-feather="search" class="feather-18 me-2"></i> Search Customer</button>
                        </div>
                    </div>
                </div>
                @endif
                @if(isset($customer))
                <div class="row mt-3">
                    <div class="col-xs-12 d-flex justify-content-start align-items-center mt-1">
                        <button class="btn btn-primary d-flex justify-content-between align-items-center" disabled><i data-feather="user-plus" class="feather-18 me-2"></i> Request Water Works</button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('custom-js')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{ asset('assets/js/form-search-animation.js') }}" defer></script>

@endsection