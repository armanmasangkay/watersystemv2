@extends('layout.main')

@section('title', 'Register a Customer')


@section('content')
<div class="row justify-content-center">
    <div class="col col-lg-12 col-xl-8">
        <div class="card mt-5 rounded-3 mb-5 shadow">
            <div class="card-header p-4 text-center">
                <h4><i data-feather="users" class="feather-32"></i>&nbsp;&nbsp;Customer Data</h4>
            </div>
            <div class="card-body px-3 px-lg-5">
                <small class="mb-5 text-danger">Note: (*) Required fields</small>
                <form action="" method="post" class="mt-4" id="registration-form">
                   
                    <p class="text-primary">Person Information</p>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12 col-lg-4 mb-2">
                            <label><small class="text-muted">Firstname</small><small class="text-danger"> *</small></label>
                            <input type="text" name="firstname" id="" class="form-control mt-2" placeholder="First name" >
                            <small id="error-firstname" class="text-danger" hidden>
                                
                            </small>
                        </div>
                       
                        <div class="col-12 col-lg-4">
                            <small class="text-muted">Middlename (optional)</small>
                            <input type="text" name="middlename" id="" class="form-control mt-2" placeholder="Middle name">
                        </div>
                        <div class="col-12 col-lg-4">
                            <label><small class="text-muted">Lastname</small><small class="text-danger"> *</small></label>
                            <input type="text" name="lastname" id="" class="form-control mt-2" placeholder="Last name">
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

                    <div class="row">
                        <div class="col col-md-6 col-xl-6">
                            <small class="text-muted">Purchase of Meter Option <small class="text-danger">*</small></small>
                            <select class="form-select mt-2" name="purchase_option">
                                <option value="" selected>--Please select--</option>
                                <option value="cash">Cash</option>
                                <option value="installment">Installment</option>
                              </select>
                              <small id="error-purchase-option" class="text-danger">
                             
                            </small>
                        </div>
                        <div class="col col-md-6 col-xl-6">
                            <small class='text-muted'>Ledger</small>
                            <div class="d-grid gap-2 mt-2">
                                <button class="btn btn-outline-success" type="button" data-bs-toggle='modal' data-bs-target='#ledgerSetupModal'  id="register-btn">Set up</button>
                            </div>
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

<!-- 
LEDGER MODAL
 -->
 <div class="modal fade" id="ledgerSetupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><i data-feather="book-open"></i> Ledger Setup</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h5>Beginning Meter Reading</h5>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <small class='text-muted'>Current balance</small>
                    <input class="form-control" type="number" placeholder="Enter balance" min=0>    
                </div>
                <div class="col-12 col-md-6 mt-2 col-lg-4 col-xl-3 mt-md-0">
                    <small class='text-muted'>Date of last payment</small>
                    <input class="form-control" id="lastPaymentDate" type="date">
                </div>

            </div>
           <div id="transactions-header">
                <h5 class="mt-4">Transactions</h5>
                
                <hr>
           </div>
            
            <div id="transactions-container">
                 
            </div>  
            <button type="button" class="btn btn-outline-primary btn-sm mt-4" id="add-more-btn"><i data-feather="plus"></i> Add More</button>
            
           
            
           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success">Save</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('custom-js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
const  months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

function populateDaysOnMonthOptions(numberOfDays)
{
    options=''
    for(i=1;i<numberOfDays+1;i++){
        options=options+`<option value='${i}'>${i}</option>`
    }
    return options
    
}

function newTransactionRow(currentMonth,nextMonth,currentMonthNumOfDays,nextMonthNumOfDays)
{
   return `
                    <div class='row'>
                <div class='col-6 col-md-3 col-lg-2 col-xl-1 pe-lg-0'>
                    <small class='text-danger'>${currentMonth}</small>
                    <select name='' id='' class='form-select'>
                          ${populateDaysOnMonthOptions(currentMonthNumOfDays)}  

                    </select>
                
                </div>
                <div class='col-6 col-md-3 col-lg-2 col-xl-1'>
                    <small class='text-danger'>${nextMonth}</small>
                    <select name='' id='' class='form-select'>
                        ${populateDaysOnMonthOptions(nextMonthNumOfDays)} 
                    </select>
                </div>

                <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-0 '>
                    <small class='text-muted'>Meter Reading</small>
                    <input class='form-control' type='number' min=0>    
                </div>

                <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-0'>
                    <small class='text-muted'>Consumption</small>
                    <input class='form-control' type='number' value='0.00' min=0 disabled>    
                </div>
                <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-0 '>
                    <small class='text-muted'>Amount</small>
                    <input class='form-control' type='number' value='0.00' min=0 disabled>    
                </div>
                <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-0'>
                    <small class='text-muted'>Surcharge</small>
                    <input class='form-control' type='number' value='0.00' min=0 disabled>    
                </div>
                <div class='col-12 col-md-6 col-lg-4 col-xl-2 mt-4 mt-md-0'>
                    <small class='text-muted'>Total</small>
                    <input class='form-control' type='number' value='0.00' min=0 disabled>    
                </div>

            </div>
            <hr>
        `
}

function nextMonthAfter(month,year)
{
    let monthIndex=months.indexOf(month)

    monthIndex=monthIndex+1>11?0:monthIndex+1

    return months[monthIndex]

}

function getNumberOfDays(fullYear,monthIndex)
{
    return new Date(fullYear,monthIndex+1,0).getDate()
}

$(document).ready(function(){

    
    /*
        Ledger Setup
    */
    const transactionsHeader=$("#transactions-header")
    const transactionsContainer=$("#transactions-container")
    const lastPaymentDate=$("#lastPaymentDate")
    const addMoreBtn=$("#add-more-btn")


    let previouslyAddedCurrentMonth=''
    let previouslyAddedNextMonth=''
    let previouslyAddedCurrentYear=''

    transactionsHeader.hide()
    addMoreBtn.hide()

    addMoreBtn.click((e)=>{
        e.preventDefault()
        newMonth=nextMonthAfter(previouslyAddedCurrentMonth)
        newNextMonth=nextMonthAfter(previouslyAddedNextMonth)
        newMonthWithYear=`${newMonth} ${previouslyAddedCurrentYear}`
        newNextMonthWithYear=newMonth=='Dec'?`${newNextMonth} ${previouslyAddedCurrentYear+1}`:`${newNextMonth} ${previouslyAddedCurrentYear}`

        newMonthNumOfDays=getNumberOfDays(previouslyAddedCurrentYear,months.indexOf(newMonth))
        newNextMonthNumOfDays=getNumberOfDays(previouslyAddedCurrentYear,months.indexOf(newNextMonth))

        transactionsContainer.append(newTransactionRow(newMonthWithYear,newNextMonthWithYear,newMonthNumOfDays,newNextMonthNumOfDays))
        previouslyAddedCurrentMonth=newMonth
        previouslyAddedNextMonth=newNextMonth
        previouslyAddedCurrentYear=newMonth=='Dec'?previouslyAddedCurrentYear+1:previouslyAddedCurrentYear
    })




   
    lastPaymentDate.change(()=>{

       
        transactionsHeader.show()
        addMoreBtn.show()
         //get the selected date
        let dateSelected=new Date(lastPaymentDate.val())
        

        transactionsContainer.empty()

         //determine the next month after that date
        let monthIndex=dateSelected.getMonth()+1
        let selectedYear=dateSelected.getFullYear()

        monthIndex=monthIndex>11?0:monthIndex

        let nextMonth=months[monthIndex]
        let currentMonth=months[dateSelected.getMonth()]

        currentMonthWithYear=`${currentMonth} ${selectedYear}`
        nextMonthWithYear=months[dateSelected.getMonth()]=='Dec'?`${nextMonth} ${selectedYear+1}`:`${nextMonth} ${selectedYear}`


        //generate initial transaction

        let currentMonthNumOfDays=getNumberOfDays(selectedYear,dateSelected.getMonth())
      
        let nextMonthNumOfDays=getNumberOfDays(selectedYear,monthIndex)

        transactionsContainer.append(newTransactionRow(currentMonthWithYear,nextMonthWithYear,currentMonthNumOfDays,nextMonthNumOfDays))

        previouslyAddedCurrentMonth=currentMonth
        previouslyAddedNextMonth=nextMonth
        previouslyAddedCurrentYear=months[dateSelected.getMonth()]=='Dec'?selectedYear+1:selectedYear
    
    })

   
   


})



</script>
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

                        if(response.errors.purchase_option){
                            $("#error-purchase-option").prop('hidden',false);
                            $("#error-purchase-option").html(response.errors.purchase_option)
                            $("select[name='purchase_option']").addClass('is-invalid')
                        }else{
                            $("#error-purchase-option").prop('hidden',true);
                            $("select[name='purchase_option']").removeClass('is-invalid')
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