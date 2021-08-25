@extends('layout.main')

@section('title', 'New Connection')


@section('content')
<div class="row mt-5">
    <div class="col-md-12">
        <h4 class="text-gray"><i data-feather="users" width="35" class="mb-1"></i>&nbsp;&nbsp;New Connection Entry</h4>
        <form action="{{route('admin.new-connection.store')}}" method="POST" id="registration_form">
            @csrf
            <div class="card mt-2 rounded-3 pt-2 mt-3">
                <div class="card-body px-3 px-lg-5">
                    <small class="mb-5 text-danger">Note: (*) Required fields</small>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-primary mt-4">Personal Information</p>
                            <hr>
                            <h5 class="text-muted">Information Setup</h5>
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                    <label><small class="text-muted">Organization Name</small><small class="text-muted"> (only if applicable)</small></label>
                                    <input type="text" name="org_name" class="form-control mt-2" placeholder="Organization Name" >
                                    <small id="error-organization-name" class="text-danger" hidden>
                                    </small>
                                </div>
                            </div>


                            <div class="row mt-3">


                                <div class="col-md-3 mb-2 pe-md-1">
                                    <label><small class="text-muted">Firstname</small><small class="text-danger"> *</small></label>
                                    <input type="text" name="firstname" class="form-control mt-2" placeholder="First name" >
                                    <small id="error-firstname" class="text-danger" hidden>

                                    </small>
                                </div>
                                <div class="col-md-3 ps-lg-0 pe-lg-0 ps-md-0">
                                    <small class="text-muted">Middlename (optional)</small>
                                    <input type="text" name="middlename"  class="form-control mt-2 mb-sm-2" placeholder="Middle name">
                                </div>
                                <div class="col-md-3 ps-lg-1 pt-md-0 pt-sm-2 pt-xs-2">
                                    <label><small class="text-muted">Lastname</small><small class="text-danger"> *</small></label>
                                    <input type="text" name="lastname" class="form-control mt-2" placeholder="Last name">
                                    <small id="error-lastname" class="text-danger" hidden>

                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 pe-md-1 pt-md-2 pt-sm-2">
                                    <label for=""><small class="text-muted">Civil Status</small> <small class="text-danger">*</small></label>
                                    <select name="civil_status" id="civil_status" class="form-select mb-md-2 mt-2">
                                        @foreach($civilStatuses as $civilStatus)
                                        <option value="{{$civilStatus}}">{{Str::ucfirst($civilStatus)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 ps-md-0 pt-md-2 pt-sm-2">
                                    <label for=""><small class="text-muted">Contact Number</small> <small class="text-danger">*</small></label>
                                    <input type="number" name="contact_number" id="" class="form-control mt-2" placeholder="09xxxxxxxxx">
                                    <small id="error-contact-number" class="text-danger" hidden>

                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3 pe-md-0">
                                    <label for=""><small class="text-muted">Barangay</small> <small class="text-danger">*</small></label>
                                    <select name="barangayCode" id="brgy-dropdown" class="form-select mb-3 mt-2 mb-md-2 mb-sm-2">

                                    </select>
                                    <input type="text" name="barangay" hidden>
                                    <small id="error-barangay" class="text-danger" hidden>

                                    </small>
                                </div>
                                <div class="col-md-3 ps-md-1">
                                    <label for=""><small class="text-muted">Purok</small> <small class="text-danger">*</small></label>
                                    <select name="purokCode" id="purok-dropdown" class="form-select mb-3 mt-2 mb-md-2 mb-sm-2">

                                    </select>
                                    <input type="text" name="purok" hidden>

                                    <small id="error-purok" class="text-danger" hidden>

                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3 rounded-3">
                <div class="card-body px-3 px-lg-5">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="mt-2 text-primary">Other Info</p>
                            <hr>
                            <h5 class="text-muted">Meter Connection Setup</h5>
                            <div class="row mt-3">
                                <div class="col-md-3 pe-md-1 pt-md-0 pt-sm-2">
                                    <label for=""><small class="text-muted">Connection Type</small> <small class="text-danger">*</small></label>
                                    <select name="connection_type" id="connection-type" class="form-select mt-2 mb-md-2 mb-sm-2">
                                        @foreach($connectionTypes as $connectionType)
                                        <option value="{{$connectionType}}">{{Str::ucfirst($connectionType)}}</option>
                                        @endforeach
                                    </select>
                                    <small id="error-purok" class="text-danger" hidden>

                                    </small>
                                </div>
                                <div class="col-md-3 ps-md-0 pt-md-1 pt-sm-2">
                                    <label for=""><small class="text-muted">If others, please specify</small></label>
                                    <input type="text" name="connection_type_specifics" id="connection_type_specifics" class="form-control mt-2" disabled>
                                    <small id="error-connection_type_specifics" class="text-danger">
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 pe-md-1 pt-md-0 pt-sm-2">
                                    <label for=""><small class="text-muted">Connection Status</small>  <small class="text-danger">*</small></label>
                                    <select name="connection_status" id="connection_status" class="form-select mb-sm-2 mt-2">
                                        @foreach($connectionStatuses as $connectionStatus)
                                            <option value="{{$connectionStatus}}">{{Str::ucfirst($connectionStatus)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 ps-md-0 pt-md-1 pt-sm-2">
                                    <label for=""><small class="text-muted">If others, please specify</small></label>
                                    <input type="text" name="connection_status_specifics" id="connection_status_specifics" class="form-control mt-2" disabled>
                                    <small id="error-status-specifics" class="text-danger">
                                    </small>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-3 pe-md-1 pt-md-0 pt-sm-2">
                                    <label class="text-muted"><small>Purchase of Meter Option</small> <small class="text-danger">*</small></label>
                                    <select class="form-select mt-2" name="purchase_option" id="purchase_option">
                                        <option value="" selected>--Please select--</option>
                                        <option value="cash">Cash</option>
                                        <option value="installment">Installment</option>
                                        <option value="N/A">N/A</option>
                                    </select>
                                    <small id="error-purchase_option" class="text-danger">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary modal_save"><i data-feather="user-check" width="20"></i>&nbsp; Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('custom-js')
<script src="{{ asset('assets/js/location.js') }}"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    connection_status[0].remove();
    connection_status[1].remove();
    connection_status.value = "inactive";
</script>

<script src="{{ asset('assets/js/new_connection.js') }}"></script>


@endsection
