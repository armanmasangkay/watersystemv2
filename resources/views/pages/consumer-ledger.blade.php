@extends('layout.main')

@section('title', 'Register a Customer')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-secondary">
                <div class="card-header border-secondary px-2 pb-1 pt-2 bg-light">
                    <div class="row">
                        <div class="col-md-6">
                            @include('templates.form-search-account')
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary mt-2 float-md-end"><i data-feather="user-plus" width="20"></i>&nbsp; New Water Bill</button>
                        </div>
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
                            <input type="text" class="text-bold form-control w-75 fae9d6 rounded-0 border-top-0 border-start-0 border-end-0 border-bottom border-secondary ml-3 pt-1 pb-1" value="Nobegin Masob" disabled>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between align-items-center pe-5"><span><strong>Account No:</strong></span>&nbsp;&nbsp;
                            <input type="text" class="text-bold form-control w-75 fae9d6 rounded-0 border-top-0 border-start-0 border-end-0 border-bottom border-secondary ml-3 pt-1 pb-1" value="Brgy. Bugasong" disabled>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-6 d-flex justify-content-between align-items-center pe-5"><span><strong>Address:</strong></span>&nbsp;&nbsp;
                            <input type="text" class="text-bold form-control w-75 fae9d6 rounded-0 border-top-0 border-start-0 border-end-0 border-bottom border-secondary ml-3 pt-1 pb-1" value="3306" disabled>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between align-items-center pe-5"><span><strong>Balance as of:</strong></span>&nbsp;&nbsp;
                            <input type="text" class="text-bold form-control w-75 fae9d6 rounded-0 border-top-0 border-start-0 border-end-0 border-bottom border-secondary ml-3 pt-1 pb-1" value="2,000.00" disabled>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive p-0">
                        <table class="table mb-0 border-0">
                            <thead>
                                <tr>
                                    <td class="pt-1 pb-3 text-center bg-white border-end border-secondary" rowspan="2"><strong>PERIOD </br>COVERED</strong></td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary" colspan="3"><strong>READING</strong></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary" colspan="3"><strong>BILLING</strong></td>
                                    <td class="pt-2 pb-2 text-center eee" colspan="4"><strong>PAYMENT</strong></td>
                                </tr>
                                <tr>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary"><strong>DATE</strong></td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary"><strong>METER READING</strong></td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary"><strong>CONSUMPTION</strong></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><strong>DUE AMOUNT</strong></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><strong>SURCHARGE</strong></td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary"><strong>TOTAL DUE</strong></td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary"><strong>OR NO</strong></td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary"><strong>DATE PAID</strong></td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary"><strong>AMOUNT</strong></td>
                                    <td class="pt-2 pb-2 text-center eee"><strong>POSTED BY</strong></td>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="pt-2 pb-2 text-center bg-white border-end border-secondary">Beginning Bal.</td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary">5/18/21</td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary">10002</td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary">54.01</td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary">100.00</td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary">0.00</td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary">100.00</td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary">OR-1000</td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary">5/10/21</td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary">100.00</td>
                                    <td class="pt-2 pb-2 text-center eee">Benj Masub</td>
                                </tr>
                                <tr>
                                    <td class="pt-2 pb-2 text-center bg-white border-end border-secondary">May-05-2021</td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary">5/18/21</td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary">10002</td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary">54.01</td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary">100.00</td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary">0.00</td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary">100.00</td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary">OR-1000</td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary">5/10/21</td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary">100.00</td>
                                    <td class="pt-2 pb-2 text-center eee">Benj Masub</td>
                                </tr>
                                <tr>
                                    <td class="pt-2 pb-2 text-center bg-white border-end border-secondary">June-01-2021</td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary">5/18/21</td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary">10002</td>
                                    <td class="pt-2 pb-2 text-center f0f0f0 border-end border-secondary">54.01</td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary">100.00</td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary">0.00</td>
                                    <td class="pt-2 pb-2 text-center f8d6b0 border-end border-secondary">100.00</td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary">OR-1000</td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary">5/10/21</td>
                                    <td class="pt-2 pb-2 text-center eee border-end border-secondary">100.00</td>
                                    <td class="pt-2 pb-2 text-center eee">Benj Masub</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="pt-3 pb-3 px-2 bg-light">
                            <button class="btn btn-primary rounded-sm">
                                <i data-feather="chevrons-left" width="20"></i> Prev
                            </button>
                            <button class="btn btn-default rounded-sm">1</button>
                            <button class="btn btn-default rounded-sm">2</button>
                            <button class="btn btn-default rounded-sm">3</button>
                            <button class="btn btn-default rounded-sm">4</button>
                            <button class="btn btn-default rounded-sm">5</button>
                            <button class="btn btn-primary rounded-sm"> Next
                                <i data-feather="chevrons-right" width="20"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection