$(document).ready(function(){

    $('#carbon_date_billing').datepicker({ 
        autoclose: true, 
        todayHighlight: true,
    }).datepicker('update', new Date());

    var date =  new Date($('#carbon_date_billing').val())
    var newDate = date.toDateString().split(' '),
        cleanDate = date.toLocaleString('default', { month: 'long' }) + ' ' + newDate[2] + ', ' + newDate[3]
        numDate = new Date($('#carbon_date_billing').val()).toLocaleString().split(',')[0]

    $('#reading_date').val(numDate)
    $('#carbon_date_billing').val(cleanDate)

    $("#billing-form").on('submit', function(e){
        e.preventDefault();

        let registerForm = document.getElementById('billing-form')
        let actionURI = registerForm.getAttribute('action')


        if($('#reading_date').val() != '')
        {
            $('#save-billing').html('<i class="far fa-spinner fa-spin"></i>&nbsp; Processing ...');
            $('#save-billing').prop('disabled', true);
            $('#current-month').prop('disabled', false);
            $('#next-month').prop('disabled', false);

            let data = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: actionURI,
                data: data,
                success: function(response){

                    if(response.created == true){
                        $('#current-month').prop('disabled', true);
                        $('#next-month').prop('disabled', true);
                        $('#save-billing').html('<i class="far fa-check"></i>&nbsp; Done!');

                        Swal.fire('Billing Successfull!','New billing for client '+ $('input[name="customer_id"]').val() +' was created!','success').then(function(result){
                            if(result.isConfirmed)
                            {
                                window.location.reload();
                            }
                        })
                    }
                    else{
                        Swal.fire('Ooops!',response.msg)
                    }
                }
            })
        }
        else
        {
            Swal.fire('Ooops!','Please select reading date first!','error');
        }

    });

    $('#reading_meter').on('keyup', function(){

        if(parseInt($(this).val()) >= parseInt($('#meter-reading').val()))
        {
            const max_range = parseFloat($('input[name="max_range"]').val());
            const min_rates = parseFloat($('input[name="min_rates"]').val());
            const excess_rate = parseFloat($('input[name="billing_excess_rate"]').val());
            const payment_or = $('input[name="or_num"]').val();
            const balance = parseFloat($('input[name="cur_balance"]').val());
            const surcharge_rate = parseFloat($('input[name="surcharge"]').val());
            const meter_ips = parseFloat($('input[name="meter_ips"]').val());

            const surcharge = (payment_or != null ? (balance * surcharge_rate) : 0.00);

            const meter_consumption = parseInt($('#reading_meter').val(), 10) - parseInt($('#meter-reading').val(), 10);
            const total_consumption = ((meter_consumption - max_range) * excess_rate) + min_rates;
            const amount_consumption = meter_consumption <= max_range ? min_rates : total_consumption;
            
            $('#consumption').val(meter_consumption);
            $('#surcharge_amount').val(surcharge.toFixed(2));
            $('#amount').val(amount_consumption.toFixed(2));

            const total = ((surcharge + balance) + (meter_ips + amount_consumption));

            $('#total').val(total.toFixed(2));
            $('#save-billing').prop('disabled', false);

            let data = $('#billing-form').serialize();
            var APP_CSRF = $("input[name='_token']").val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': APP_CSRF
                },
                type: 'POST',
                url: "/get/computed/water-bill",
                data: {'reading_meter' : $('input[name="reading_meter"]').val(), customer_id: $('#account_number').val()},
                success: function(response){
                    
                }
            })
        }
        else{
            $('#save-billing').prop('disabled', true);
            $('#consumption').val(0);
            $('#surcharge_amount').val('0.00');
            $('#amount').val('0.00');
            $('#total').val('0.00');
        }
    });

    $(document).on('click', '#override', function(){
        if($(this).is(':checked'))
        {
            $('#current-month').prop('disabled', false);
            $('#next-month').prop('disabled', false);
        }
        else
        {
            $('#current-month').prop('disabled', true);
            $('#next-month').prop('disabled', true);
        }
    })

    $('#carbon_date_billing').change(function(){
        var date =  new Date($(this).val())
        var newDate = date.toDateString().split(' '),
            cleanDate = date.toLocaleString('default', { month: 'long' }) + ' ' + newDate[2] + ', ' + newDate[3]
            numDate = new Date($(this).val()).toLocaleString().split(',')[0]

        $('#carbon_date_billing').val(cleanDate)
        $('#reading_date').val(numDate)
    })

    function format_number(n) {
        return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }

});
