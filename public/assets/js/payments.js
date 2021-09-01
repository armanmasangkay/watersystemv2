$(document).ready(function()
{
    $('#carbon_date').datepicker({ 
        autoclose: true, 
        todayHighlight: true,
    }).datepicker('update', new Date());

    var date =  new Date($('#carbon_date').val())
    var newDate = date.toDateString().split(' '),
        cleanDate = date.toLocaleString('default', { month: 'long' }) + ' ' + newDate[2] + ', ' + newDate[3]
        numDate = new Date($('#carbon_date_billing').val()).toLocaleString().split(',')[0]

    $('#payment_date').val(numDate)
    $('#carbon_date').val(cleanDate)
    
    $(document).on('click', '#paymentBtn', function()
    {
        var balance = $('#currentBalance strong').html()
        var res = balance.split(' ')
        let actionURI = $('input[name="route"]').val()

        if( ! parseFloat(res[1]) > 0 )
        {
            Swal.fire('Payment Reminder!','Client '+ $('input[name="customer_id"]').val() +' current balance is 0.00','info')
        }
        else
        {
        
            $.ajax({
                method: 'POST',
                url: actionURI,
                data: {_token: $('input[name="_token"]').val()},
                success: function(responseData){

                    if(responseData.getBalance == true){

                        $('#paymentModal').modal('show')

                        var period = responseData.bal.period_covered
                        var result = period.split('-')
                        var year = (period != 'Beginning Balance') ?? result[1].split(',')
                        var date =  new Date(responseData.bal.reading_date)
                        var newDate = date.toDateString().split(' '),
                            cleanDate = newDate[0] + ', ' + newDate[1] + '. ' + newDate[2] + ', ' + newDate[3]

                        $('input[name="from"]').val((period == 'Beginning Balance') ? 'Beginning Balance' : result[0] )
                        $('input[name="to"]').val((period == 'Beginning Balance') ? '' : result[1])
                        $('input[name="curr_transaction_id"]').val(responseData.bal.id)
                        $('input[name="meter_reading"]').val(responseData.bal.reading_meter)
                        $('input[name="curr_balance"]').val(format_number(responseData.bal.balance))
                        $('input[name="date"]').val(cleanDate)
                        $('input[name="read_meter"]').val(responseData.bal.reading_meter)
                        $('input[name="consumpt"]').val(responseData.bal.reading_consumption)
                        $('input[name="consumpt_amount"]').val(format_number(responseData.bal.billing_amount))
                        $('input[name="sur_amount"]').val(format_number(responseData.bal.billing_surcharge))
                        $('input[name="meterIPS"]').val(format_number(responseData.bal.billing_meter_ips))
                        $('input[name="totalAmount"]').val(format_number(responseData.bal.balance))
                    }
                    else{
                        Swal.fire('Ooops!',"There was an error on saving the consumer's bill!")
                    }
                }
            })
        }
    })

    $('#inputedAmount').on('keyup', function(){
        if(parseFloat($(this).val()) > 0)
        {
            var total = 0, change = 0, remaining = 0;
            if( parseFloat($('input[name="inputedAmount"]').val()) > parseFloat($('input[name="totalAmount"]').val()) )
            {
                total = parseFloat($('input[name="inputedAmount"]').val()) - parseFloat($('input[name="totalAmount"]').val())
                change = total
                remaining = total > 0 ? 0 : total
            }
            else
            {
                total = parseFloat($('input[name="totalAmount"]').val()) - parseFloat($('input[name="inputedAmount"]').val())
                change = 0
                remaining = total
            }
            
            $('input[name="remaining_bal"]').val(format_number(remaining))
            $('input[name="change"]').val(format_number(change))

            $('#save-payment').prop('disabled', false);
        }
        else
        {
            $('input[name="remaining_bal"]').val(format_number(parseFloat($('input[name="totalAmount"]').val())))
            $('input[name="change"]').val(format_number(0))
            $('#save-payment').prop('disabled', true);
        }
    })

    function format_number(n) {
        return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }

    $('#payment-form').on('submit', function(e){
        e.preventDefault()

        if( parseFloat($('input[name="inputedAmount"]').val()) > 0 )
        {
            if($('input[name="orNum"]').val() == '')
            {
                Swal.fire('Invalid Payment!', 'OR number cannot be empty!','warning')
            }
            else
            {
                $('#save-payment').html('<i class="far fa-spinner fa-spin"></i>&nbsp; Processing ...');
                $('#save-payment').prop('disabled', true);

                let registerForm = document.getElementById('payment-form')
                let actionURI = registerForm.getAttribute('action')
                
                let data = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: actionURI,
                    data: data,
                    success: function(response){
                        if(response.created == true){
                            $('#save-payment').html('<i class="far fa-check"></i>&nbsp; Done!');

                            Swal.fire('Payment Successfull!','New payment for client '+ $('input[name="customer_id"]').val() +' was created!','success').then(function(result){
                                if(result.isConfirmed)
                                {
                                    window.location.reload();
                                }
                            })
                            console.log(response)
                        }
                        else{
                            Swal.fire('Ooops!', response.errors)
                        }
                    }
                })
            }
        }
    })

    $('#carbon_date').change(function(){
        var date =  new Date($(this).val())
        var newDate = date.toDateString().split(' '),
            cleanDate = date.toLocaleString('default', { month: 'long' }) + ' ' + newDate[2] + ', ' + newDate[3]
            numDate = new Date($(this).val()).toLocaleString().split(',')[0]

        $('#carbon_date').val(cleanDate)
        $('#payment_date').val(numDate)
    })
})