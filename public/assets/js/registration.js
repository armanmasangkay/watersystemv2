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
            <div class='row px-md-2'>
                <div class='col-6 col-md-3 col-lg-2 col-xl-1 mt-2 pe-md-1 ps-md-1 ps-lg-1 pe-sm-1 pe-1'>
                    <small class='text-danger'>${currentMonth}</small>
                    <select name='' id='' class='form-select'>
                        ${populateDaysOnMonthOptions(currentMonthNumOfDays)}
                    </select>

                </div>
                <div class='col-6 col-md-3 col-lg-2 col-xl-1 mt-2 ps-md-0 pe-md-0 ps-sm-0 ps-0'>
                    <small class='text-danger'>${nextMonth}</small>
                    <select name='' id='' class='form-select'>
                        ${populateDaysOnMonthOptions(nextMonthNumOfDays)}
                    </select>
                </div>

                <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-lg-2 mt-md-2 px-lg-1 pe-sm-1 ps-md-1 pe-1'>
                    <small class='text-muted'>Meter Reading</small>
                    <input class='form-control' type='number' min=0 id="meter_reading">
                </div>

                <div class='col-6 col-md-6 col-lg-4 col-xl-1 mt-2 mt-lg-2 mt-md-2 px-lg-0 ps-md-1 pe-md-0 ps-sm-0 ps-0'>
                    <small class='text-muted'>Consumption</small>
                    <input class='form-control' type='number' value='0.00' min=0 disabled>
                </div>
                <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-2 px-lg-1 pe-sm-1 ps-md-1 pe-1'>
                    <small class='text-muted'>Amount</small>
                    <input class='form-control' type='number' value='0.00' min=0 disabled>
                </div>
                <div class='col-6 col-md-6 col-lg-4 col-xl-1 mt-2 mt-md-2 px-lg-0 ps-md-1 pe-md-0 ps-sm-0 ps-0'>
                    <small class='text-muted'>Surcharge</small>
                    <input class='form-control' type='number' value='0.00' min=0 disabled>
                </div>
                <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-2 px-lg-1 pe-sm-1 ps-md-1 pe-1'>
                    <small class='text-muted'>Meter installment balance</small>
                    <input class='form-control' type='number' value='0.00' min=0>
                </div>
                <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-2 ps-lg-0 ps-md-1 pe-lg-1 ps-sm-0 pe-md-0 ps-0'>
                    <small class='text-muted'>Total</small>
                    <input class='form-control' type='number' value='0.00' min=0 disabled>
                </div>
            </div>
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

function addDataToForm(form,balance, meterReading,lastPaymentDate)
{
    form.empty()
    form.append(
        `
            <input type="hidden" value="${balance.val()}" name="balance">
            <input type="hidden" value="${meterReading.val()}" name="reading_meter">
            <input type="hidden" value="${lastPaymentDate.val()}" name="reading_date">
        `
    )
}

function enableSaveButton(saveBtn, balance, meterReading,lastPaymentDate)
{
    if(meterReading.val() != "" && balance.val() != "" && lastPaymentDate.val() != "")
    {
        saveBtn.removeAttr('disabled')
    }
}

function createTransaction(balance, meterReading,lastPaymentDate, transactionsHeader, transactionsContainer, previouslyAddedCurrentMonth, previouslyAddedNextMonth,previouslyAddedCurrentYear){
    if(meterReading.val() != "" && balance.val() != "" && lastPaymentDate.val() != "")
    {
        balance.attr('disabled', 'disabled')
        meterReading.attr('disabled', 'disabled')
        transactionsHeader.show()
        // addMoreBtn.show()
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

    }
}



$(document).ready(function(){

    /*
        Ledger Setup
    */
    const transactionsHeader=$("#transactions-header")
    const transactionsContainer=$("#transactions-container")
    const lastPaymentDate=$("#lastPaymentDate")
    const addMoreBtn=$("#add-more-btn")
    const meterReading = $('#meter-reading')
    const balance = $('#balance')
    const closeButton = $('#close-button')
    const saveButton = $('#save-button')
    const form = $('#transaction-data')


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
        enableSaveButton(saveButton, balance, meterReading,lastPaymentDate)
    })
    meterReading.change(()=>{
        enableSaveButton(saveButton, balance, meterReading,lastPaymentDate)
    })
    balance.change(()=>{
        enableSaveButton(saveButton, balance, meterReading,lastPaymentDate)
    })

    closeButton.click(()=>{
        balance.removeAttr('disabled', 'disabled')
        meterReading.removeAttr('disabled', 'disabled')
        transactionsHeader.hide()
        transactionsContainer.empty()
    })

    saveButton.click(()=>{
        $('#register-btn').removeAttr('disabled')
        addDataToForm(form,balance, meterReading,lastPaymentDate)
    })

    const registerBtn=$("#register-btn");
    const registrationForm=$("form");

    // registerBtn.prop('disabled',false);


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
        let registerForm = document.getElementById('registration-form')
        let actionURI = registerForm.getAttribute('action')
        let token = document.getElementsByName('_token')[0].value

        let data=$(this).serialize()+`${token}`;
            $.post(actionURI,data,function(response){
                console.log(response)
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

        $(document).keyup('#meter_reading', function(e){
            if(e.keyCode === 13){
                e.preventDefault()
                $('.modal_save').removeAttr('disabled')
            }
        })
    })
