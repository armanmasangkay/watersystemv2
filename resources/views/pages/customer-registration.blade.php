@extends('layout.main')

@section('title', 'Register a Customer')


@section('content')
<div class="row justify-content-center">
    <div class="col col-lg-12 col-xl-8">
        <div class="card mt-5 rounded-3 mb-5 shadow">
            <div class="card-header pt-4 pb-3 text-center">
                <h4><i data-feather="users" class="feather-32"></i>&nbsp;&nbsp;Customer Data</h4>
            </div>
            <div class="card-body px-3 px-lg-5">
                <small class="mb-5 text-danger">Note: (*) Required fields</small>
                <form action="{{ route('admin.register-customer-post') }}" method="post" class="mt-4" id="registration-form">
                    @csrf
                    <p class="text-primary">Person Information</p>
                    <hr>
                    <div class="row mb-1">
                        <div class="col-12 col-lg-4 col-md-6 mb-2 pe-md-1">
                            <label><small class="text-muted">Firstname</small><small class="text-danger"> *</small></label>
                            <input type="text" name="firstname"  class="form-control mt-2" placeholder="First name" >
                            <small id="error-firstname" class="text-danger" hidden>

                            </small>
                        </div>

                        <div class="col-12 col-lg-4 col-md-6 ps-lg-0 pe-lg-0 ps-md-0">
                            <small class="text-muted">Middlename (optional)</small>
                            <input type="text" name="middlename"  class="form-control mt-2 mb-sm-2" placeholder="Middle name">
                        </div>
                        <div class="col-12 col-lg-4 col-md-6 ps-lg-1 pt-md-0 pt-sm-2 pt-xs-2">
                            <label><small class="text-muted">Lastname</small><small class="text-danger"> *</small></label>
                            <input type="text" name="lastname"  class="form-control mt-2" placeholder="Last name">
                            <small id="error-lastname" class="text-danger" hidden>

                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 pe-md-1 pt-md-2 pt-sm-2">
                            <label for=""><small class="text-muted">Civil Status</small> <small class="text-danger">*</small></label>
                            <select name="civil_status" id="civil_status" class="form-select mb-md-2 mt-2">
                                @foreach($civilStatuses as $civilStatus)
                                <option value="{{$civilStatus}}">{{Str::ucfirst($civilStatus)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 ps-md-0 pt-md-2 pt-sm-2">
                            <label for=""><small class="text-muted">Contact Number</small> <small class="text-danger">*</small></label>
                            <input type="number" name="contact_number"  class="form-control mt-2" placeholder="09xxxxxxxxx">
                            <small id="error-contact-number" class="text-danger" hidden>

                            </small>
                        </div>
                    </div>
                    <p class="mt-3 text-primary">Address</p>
                    <hr>
                    <div class="row">
                        <div class="col-12 col-lg-6 col-md-6 pe-md-1">
                            <label for=""><small class="text-muted">Purok</small> <small class="text-danger">*</small></label>
                            <input type="text" name="purok"  class="form-control mt-2 mb-md-2 mb-sm-2">
                            <small id="error-purok" class="text-danger" hidden>

                            </small>
                        </div>
                        <div class="col-12 col-lg-6 col-md-6 ps-md-0">
                            <label for=""><small class="text-muted">Barangay</small> <small class="text-danger">*</small></label>
                            <select name="barangay"  class="form-select mb-3 mt-2 mb-md-2 mb-sm-2">
                                @foreach($barangays as $barangay)
                                <option value="{{$barangay}}">{{$barangay}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <p class="mt-2 text-primary">Other Info</p>
                    <hr>
                    <div class="row">
                        <div class="col-12 col-lg-6 col-md-6 pe-md-1 pt-md-0 pt-sm-2">
                            <label for=""><small class="text-muted">Connection Type</small> <small class="text-danger">*</small></label>
                            <select name="connection_type" id="connection-type" class="form-select mt-2 mb-md-2 mb-sm-2">
                                @foreach($connectionTypes as $connectionType)
                                <option value="{{$connectionType}}">{{Str::ucfirst($connectionType)}}</option>
                                @endforeach
                            </select>
                            <small id="error-purok" class="text-danger" hidden>

                            </small>
                        </div>
                        <div class="col-12 col-lg-6 col-md-6 ps-md-0 pt-md-1 pt-sm-2">
                            <label for=""><small class="text-muted">If others, please specify</small></label>
                            <input type="text" name="connection_type_specifics" id="connection_type_specifics" class="form-control mt-2" disabled>
                            <small id="error-type-specifics" class="text-danger">
                            </small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-6 col-md-6 pe-md-1 pt-md-0 pt-sm-2">
                            <label for=""><small class="text-muted">Connection Status</small>  <small class="text-danger">*</small></label>
                            <select name="connection_status" id="connection-status" class="form-select mb-sm-2 mt-2">
                                @foreach($connectionStatuses as $connectionStatus)
                                <option value="{{$connectionStatus}}">{{Str::ucfirst($connectionStatus)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-lg-6 col-md-6 ps-md-0 pt-md-1 pt-sm-2">
                            <label for=""><small class="text-muted">If others, please specify</small></label>
                            <input type="text" name="connection_status_specifics" id="connection_status_specifics" class="form-control mt-2" disabled>
                            <small id="error-status-specifics" class="text-danger">
                            </small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-6 col-md-6 pe-md-1 pt-md-0 pt-sm-2">
                            <label class="text-muted"><small>Purchase of Meter Option</small> <small class="text-danger">*</small></label>
                            <select class="form-select mt-2" name="purchase_option">
                                <option value="" selected>--Please select--</option>
                                <option value="cash">Cash</option>
                                <option value="installment">Installment</option>
                            </select>
                            <small id="error-purchase-option" class="text-danger">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-6 col-md-6 pt-md-2 pt-sm-2">
                            <label class='text-muted'><small>Ledger setup</small></label>
                            <div class="mt-2">
                                <button class="btn btn-outline-success" type="button" data-bs-toggle='modal' data-bs-target='#ledgerSetupModal'  id="setup-btn"><i data-feather="settings" class="feather-18" width="18"></i>&nbsp; Set up now</button>
                            </div>
                        </div>
                    </div>

                    <div id="transaction-data">

                    </div>

                    <center>
                        <button class="btn btn-primary py-2 mt-5" type="Submit" disabled id="register-btn"><i data-feather="user-plus" class="feather-18" width="18"></i>&nbsp; Register</button>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>

<!--
LEDGER MODAL
 -->
<div class="modal modal-fluid fade" id="ledgerSetupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-muted" id="exampleModalLabel"><i data-feather="book-open"></i> Ledger Setup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 class="text-muted">Beginning Meter Reading</h5>
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-xl-3 col-sm-6 mb-sm-2 pe-md-1 pe-sm-1">
                        <label class='text-muted'>Previous meter reading</label>
                        <input class="form-control" id="meter-reading" type="number" placeholder="Enter meter reading" min=0>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-3 col-sm-6 mt-md-0 px-md-0 ps-sm-0">
                        <label class='text-muted'>Amount balance</label>
                        <input class="form-control" type="number" id="balance" placeholder="Enter balance" min=0>
                    </div>
                    <div class="col-md-4 mt-2 col-lg-4 col-xl-3 col-sm-6 mt-md-0 ps-md-1 pe-sm-1">
                        <label class='text-muted'>Date of last payment</label>
                        <input class="form-control" id="lastPaymentDate" type="date">
                    </div>
                </div>
                <div id="transactions-header">
                    <h5 class="mt-4 text-muted">Transactions</h5>
                    <i id="close-button">X</i>
                    <hr class="text-muted">
                </div>

                <div id="transactions-container">

                </div>
                <button type="button" class="btn btn-outline-primary btn-sm mt-4" id="add-more-btn"><i data-feather="plus"></i> Add More</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success modal_save" id="save-button" data-bs-dismiss="modal" disabled>Save</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom-js')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="{{ asset('assets/js/registration.js') }}" defer></script>


@endsection
