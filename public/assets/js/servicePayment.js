$(document).ready(function(){

    $('#carbon_date_service').datepicker({ 
        autoclose: true, 
        todayHighlight: true,
    }).datepicker('update', new Date());

    var date =  new Date($('#carbon_date_service').val())
    var newDate = date.toDateString().split(' '),
        cleanDate = date.toLocaleString('default', { month: 'long' }) + ' ' + newDate[2] + ', ' + newDate[3]
        numDate = new Date($('#carbon_date_service').val()).toLocaleString().split(',')[0]

    $('#carbon_date_service').val(cleanDate)
    $('#payment_date').val(numDate)

    $('#inputedAmount').on('keyup', function(){
        if(parseFloat($(this).val()) > 0)
        {
            if(parseFloat($(this).val()) >= parseFloat($('input[name="amount"]').val()))
            {
                var change = parseFloat($(this).val()) - parseFloat($('input[name="amount"]').val())
                $('input[name="change"]').val(change.toFixed(2))

                $('#save-payment').prop('disabled', false);
            }
            else{
                $('input[name="change"]').val(0.00)
                $('#save-payment').prop('disabled', true);
            }
        }
        else{
            $('input[name="change"]').val(0.00)
            $('#save-payment').prop('disabled', true);
        }
    })

    $(document).on('click', '#payment', function(){
        $('input[name="id"]').val($(this).attr('data-id'))
        $('input[name="customer_id"]').val($(this).attr('acc-id'))
    })

    $('#payment-form').on('submit', function(e){
        e.preventDefault()
        if($('input[name="orNum"]').val() == '')
        {
            Swal.fire('Invalid Payment!', 'OR number cannot be empty!','warning')
        }
        else
        {
            $('#save-payment').html('<i class="far fa-spinner fa-spin"></i>&nbsp; Processing ...');
            $('#save-payment').prop('disabled', true);

            let payment_form = document.getElementById('payment-form')
            let actionURI = payment_form.getAttribute('action')

            let data = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: actionURI,
                data: data,
                success:function(response){
                    console.log(response)
                    if(response.created == true)
                    {
                        $('#save-payment').html('<i class="far fa-check"></i>&nbsp; Done!');

                        Swal.fire('Payment Successfull!','Service payment for client '+ $('input[name="customer_id"]').val() +' was created!','success').then(function(result){
                            if(result.isConfirmed)
                            {
                                window.location.reload();
                            }
                        })
                    }
                    else{
                        response.errors.forEach(element => {
                            Swal.fire('Ooops!', element)
                        })
                    }
                }
            })
        }
    })

    $('#carbon_date_service').change(function(){
        var date =  new Date($(this).val())
        var newDate = date.toDateString().split(' '),
            cleanDate = date.toLocaleString('default', { month: 'long' }) + ' ' + newDate[2] + ', ' + newDate[3]
            numDate = new Date($(this).val()).toLocaleString().split(',')[0]

        $('#carbon_date_service').val(cleanDate)
        $('#payment_date').val(numDate)
    })
})