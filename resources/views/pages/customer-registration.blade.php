@extends('layout.main')

@section('title', 'Register a Customer')


@section('content')
<div class="row justify-content-center">
    <div class="col col-lg-12 col-xl-8">
        <div class="card mt-5 rounded-3 mb-5 shadow">
            <div class="card-header p-4 text-center">
                <h4><i data-feather="users" class="feather-32"></i>&nbsp;&nbsp;Register a Customer</h4>
            </div>
            <div class="card-body px-3 px-lg-5">
                <small class="mb-5 text-danger">Note: (*) Required fields</small>
                <form action="" method="post" class="mt-4" id="registration-form">
                   
                    <p class="text-primary">Person Information</p>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12 col-lg-4 mb-2">
                            <small class="text-danger">*</small>
                            <input type="text" name="firstname" id="" class="form-control" placeholder="First name" >
                            <small id="error-firstname" class="text-danger" hidden>
                                
                            </small>
                        </div>
                       
                        <div class="col-12 col-lg-4">
                            <small class="text-muted">(optional)</small>
                            <input type="text" name="middlename" id="" class="form-control" placeholder="Middle name">
                        </div>
                        <div class="col-12 col-lg-4">
                            <small class="text-danger">*</small>
                            <input type="text" name="lastname" id="" class="form-control" placeholder="Last name">
                            <small id="error-lastname" class="text-danger" hidden>
                              
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <label for=""><small class="text-muted">Civil Status</small> <small class="text-danger">*</small></label>
                            <select name="civil_status" id="civil_status" class="form-select mb-3 mt-2">
                                @foreach($civilStatuses as $civilStatus)
                                <option value="{{$civilStatus}}">{{Str::ucfirst($civilStatus)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for=""><small class="text-muted">Contact Number</small> <small class="text-danger">*</small></label>
                            <input type="number" name="contact_number" id="" class="form-control mt-2" placeholder="09xxxxxxxxx">
                            <small id="error-contact-number" class="text-danger" hidden>
                                
                            </small>
                        </div>
                    </div>
                    <p class="mt-3 text-primary">Address</p>
                    <hr>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <label for=""><small class="text-muted">Purok</small> <small class="text-danger">*</small></label>
                            <input type="text" name="purok" id="" class="form-control mt-2">
                            <small id="error-purok" class="text-danger" hidden>
                                
                            </small>
                        </div>
                        <div class="col-12 col-lg-6">
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
                        <div class="col-12 col-lg-6">
                            <label for=""><small class="text-muted">Connection Type</small>  <small class="text-danger">*</small></label>
                            <select name="connection_type" id="connection-type" class="form-select mb-3 mt-2">
                                @foreach($connectionTypes as $connectionType)
                                <option value="{{$connectionType}}">{{Str::ucfirst($connectionType)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for=""><small class="text-muted">If others, please specify</small></label>
                            <input type="text" name="connection_type_specifics" id="connection_type_specifics" class="form-control mt-2" disabled>
                            <small id="error-type-specifics" class="text-danger">
                                  
                            </small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <label for=""><small class="text-muted">Connection Status</small>  <small class="text-danger">*</small></label>
                            <select name="connection_status" id="connection-status" class="form-select mb-3 mt-2">
                                @foreach($connectionStatuses as $connectionStatus)
                                <option value="{{$connectionStatus}}">{{Str::ucfirst($connectionStatus)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for=""><small class="text-muted">If others, please specify</small></label>
                            <input type="text" name="connection_status_specifics" id="connection_status_specifics" class="form-control mt-2" disabled>
                            <small id="error-status-specifics" class="text-danger">
                               
                            </small>
                        </div>
                      
                    </div>
                
                    <div class="d-grid gap-2 col-4 col-lg-3 mx-auto mt-4">
                        <button class="btn btn-primary py-2" type="Submit" disabled id="register-btn">Register</button>
                    
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
        const registerBtn=$("#register-btn");
        const registrationForm=$("form");

        registerBtn.prop('disabled',false);


        /*
            Connection Type & connection status is changed
        */
        
        const connectionTypeSelect=$("#connection-type");
        const connectionTypeSpecificsField=$("#connection_type_specifics");
        connectionTypeSelect.change(function(e){
            let selectedValue=$(this).val();
            if(selectedValue==="others"){
                connectionTypeSpecificsField.prop('disabled',false)
            }else{
                connectionTypeSpecificsField.prop('disabled',true)
                connectionTypeSpecificsField.val("")
            }
        })

        const connectionStatusSelect=$("#connection-status");
        const connectionStatusSpecificsField=$("#connection_status_specifics");
        connectionStatusSelect.change(function(e){
            let selectedValue=$(this).val();
            if(selectedValue==="others"){
                connectionStatusSpecificsField.prop('disabled',false)
            }else{
                connectionStatusSpecificsField.prop('disabled',true)
                connectionStatusSpecificsField.val("")
            }
        })
        




        /*
            Registration Form submitted
        */
        $("#registration-form").submit(function(e){
            e.preventDefault();
            registerBtn.prop('disabled',true);
            registerBtn.html("Registering..")

            let data=$(this).serialize()+"&_token={{csrf_token()}}";
                $.post("{{route('admin.register-customer')}}",data,function(response){
                
                    if(response.created==true){
                        Swal.fire('Great!','Customer account was successfully created!','success').then(function(result){
                            if(result.isConfirmed)
                            {
                                window.location.reload();
                            }
                        })

                    }else{
                       
                        if(response.errors.firstname){
                            $("#error-firstname").prop('hidden',false);
                            $("#error-firstname").html(response.errors.firstname)
                            $("input[name='firstname']").addClass('is-invalid')
                        }else{
                            $("#error-firstname").prop('hidden',true);
                            $("input[name='firstname']").removeClass('is-invalid')
                        }
                        

                      
                        if(response.errors.lastname){
                            $("#error-lastname").prop('hidden',false);
                            $("#error-lastname").html(response.errors.lastname)
                            $("input[name='lastname']").addClass('is-invalid')
                        }else{
                            $("#error-lastname").prop('hidden',true);
                            $("input[name='lastname']").removeClass('is-invalid')
                        }

                       
                        if(response.errors.contact_number){
                            $("#error-contact-number").prop('hidden',false);
                            $("#error-contact-number").html(response.errors.contact_number)
                            $("input[name='contact_number']").addClass('is-invalid')
                        }else{
                            $("#error-contact-number").prop('hidden',true);
                            $("input[name='contact_number']").removeClass('is-invalid')
                        }

                      
                        if(response.errors.purok){
                            $("#error-purok").prop('hidden',false);
                            $("#error-purok").html(response.errors.purok)
                            $("input[name='purok']").addClass('is-invalid')
                        }else{
                            $("#error-purok").prop('hidden',true);
                            $("input[name='purok']").removeClass('is-invalid')
                        }

                       
                        if(response.errors.connection_type_specifics){
                            $("#error-type-specifics").prop('hidden',false);
                            $("#error-type-specifics").html(response.errors.connection_type_specifics)
                            $("input[name='connection_type_specifics']").addClass('is-invalid')
                        }else{
                            $("#error-type-specifics").prop('hidden',true);
                            $("input[name='connection_type_specifics']").removeClass('is-invalid')
                        }

                       
                        if(response.errors.connection_status_specifics){
                            $("#error-status-specifics").prop('hidden',false);
                            $("#error-status-specifics").html(response.errors.connection_status_specifics)
                            $("input[name='connection_status_specifics']").addClass('is-invalid')
                        }else{
                            $("#error-status-specifics").prop('hidden',true);
                            $("input[name='connection_status_specifics']").removeClass('is-invalid')
                        }

                    }
                }).always(function(){
                    registerBtn.prop('disabled',false);
                    registerBtn.html("Register")
                }).fail(function(){
                    Swal.fire('Ooops!','There seems to be a problem with your internet connection','error');
                }) 

        })
    })


</script>


@endsection