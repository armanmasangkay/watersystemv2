@extends('layout.main')

@section('title', 'Register a Customer')


@section('content')
<div class="row justify-content-center">
    <div class="col col-lg-8">
        <div class="card mt-5 rounded-3 mb-5 shadow">
            <div class="card-header p-4 text-center">
                <h4><i class="fas fa-user-plus"></i>&nbsp;&nbsp;Register a Customer</h4>
            </div>
            <div class="card-body px-5">
                <small class="mb-5 text-danger">Note: (*) Required fields</small>
                <form action="" method="post" class="mt-4">
                    @csrf
                   
                    <p class="text-primary">Person Information</p>
                    <hr>
                    <div class="row">
                        <div class="col mb-2">
                            <small class="text-danger">*</small>
                            <input type="text" name="firstname" id="" class="form-control" placeholder="First name" >
                            <small id="error-firstname" class="text-danger" hidden>
                                
                            </small>
                        </div>
                       
                        <div class="col">
                            <small class="text-muted">(optional)</small>
                            <input type="text" name="middlename" id="" class="form-control mb-3" placeholder="Middle name">
                        </div>
                        <div class="col">
                            <small class="text-danger">*</small>
                            <input type="text" name="lastname" id="" class="form-control" placeholder="Last name">
                            <small id="error-lastname" class="text-danger" hidden>
                              
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for=""><small class="text-muted">Civil Status</small> <small class="text-danger">*</small></label>
                            <select name="civil_status" id="civil_status" class="form-select mb-3 mt-2">
                                @foreach($civilStatuses as $civilStatus)
                                <option value="{{$civilStatus}}">{{Str::ucfirst($civilStatus)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for=""><small class="text-muted">Contact Number</small> <small class="text-danger">*</small></label>
                            <input type="number" name="contact_number" id="" class="form-control mt-2" placeholder="09xxxxxxxxx">
                            <small id="error-contact-number" class="text-danger" hidden>
                                
                            </small>
                        </div>
                    </div>
                    <p class="mt-3 text-primary">Address</p>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <label for=""><small class="text-muted">Purok</small> <small class="text-danger">*</small></label>
                            <input type="text" name="purok" id="" class="form-control mt-2">
                            <small id="error-purok" class="text-danger" hidden>
                                
                            </small>
                        </div>
                        <div class="col">
                            <label for=""><small class="text-muted">Barangay</small> <small class="text-danger">*</small></label>
                            <select name="barangay" id="" class="form-select mb-3 mt-2">
                                @foreach($barangays as $barangay)
                                <option value="{{$barangay}}">{{$barangay}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                
                
                    <hr>
                    <div class="row">
                        <div class="col">
                            <label for=""><small class="text-muted">Connection Type</small>  <small class="text-danger">*</small></label>
                            <select name="connection_type" id="connection-type" class="form-select mb-3 mt-2">
                                @foreach($connectionTypes as $connectionType)
                                <option value="{{$connectionType}}">{{Str::ucfirst($connectionType)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for=""><small class="text-muted">Connection Status</small>  <small class="text-danger">*</small></label>
                            <select name="connection_status" id="connection-status" class="form-select mb-3 mt-2">
                                @foreach($connectionStatuses as $connectionStatus)
                                <option value="{{$connectionStatus}}">{{Str::ucfirst($connectionStatus)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                
                    <div class="d-grid gap-2 col-4 mx-auto mt-4">
                        <button class="btn btn-primary py-2" type="Submit">Register</button>
                    
                    </div>
                
                
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function(){
        $("form").submit(function(e){
            e.preventDefault();

            $.post("{{route('admin.register-customer')}}",$(this).serialize(),function(response){
               
                if(response.created==true){
                    Swal.fire('Great!','Customer account was successfully created!','success');
                }else{
                    $("#error-firstname").prop('hidden',false);


                    //TODO add is-invalid class to errors
                    if(response.errors.firstname){
                        $("#error-firstname").html(response.errors.firstname)
                    }
                    

                    $("#error-lastname").prop('hidden',false);
                    if(response.errors.lastname){
                        $("#error-lastname").html(response.errors.lastname)
                    }

                    $("#error-contact-number").prop('hidden',false);
                    if(response.errors.contact_number){
                        $("#error-contact-number").html(response.errors.contact_number)
                    }
                    $("#error-purok").prop('hidden',false);
                    if(response.errors.purok){
                        $("#error-purok").html(response.errors.purok)
                    }
                }
            })
        })
    })


</script>


@endsection