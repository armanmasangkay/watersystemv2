$(document).ready(function(){

    $('#print-bill').click(function(){
        if($(this).attr('data-enable') == 1)
        {
            $('#reload').attr('data-enable', 1)
            window.print()
        }
    })

    $('#reload').click(function(){
        if($(this).attr('data-enable') == 1)
        {
            window.location.reload()
        }
    })

    $(document).on('submit', '#billing-form', function(e){
        e.preventDefault();

        let registerForm = document.getElementById('billing-form')
        let actionURI = registerForm.getAttribute('action')


        if($('#reading_date').val() != '')
        {
            $('#save-billing').html('<i class="far fa-spinner fa-spin"></i>&nbsp; Processing ...');
            $('#save-billing').prop('disabled', true);

            let data = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: actionURI,
                data: data,
                success: function(response){
                    if(response.created == true){
                        console.log(response)
                        $('#save-billing').html('<i class="far fa-check"></i>&nbsp; Done!');

                        Swal.fire('Billing Successfull!','New billing for client '+ $('input[name="customer_id"]').val() +' was created!','success').then(function(result){
                            if(result.isConfirmed)
                            {
                                $('#print-bill').attr('data-enable', 1)
                                $('#ledgerSetupModal').modal('hide')
                            }
                        })
                    }
                    else{
                        Swal.fire('Ooops!',response.msg).then(function(result){
                            if(result.isConfirmed)
                            {
                                window.location.reload();
                            }
                        })
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
            $('#mtr_cur').text($(this).val() + ' Cu.M');

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
            $('#mtr_con').text(meter_consumption + ' Cu.M');
            $('#surcharge_amount').val(surcharge.toFixed(2));
            $('#mtr_sur').text(surcharge.toFixed(2));
            $('#amount').val(amount_consumption.toFixed(2));
            $('#mtr_cur_bill').text('Php '+ amount_consumption.toFixed(2));

            const total = ((surcharge + balance) + (meter_ips + amount_consumption));

            $('#total').val(total.toFixed(2));
            $('#mtr_due').text('Php ' + total.toFixed(2));
            $('#save-billing').prop('disabled', false);

            let data = $('#billing-form').serialize();
            var APP_CSRF = $("input[name='_token']").val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': APP_CSRF
                },
                type: 'POST',
                url: "/get/computed/water-bill",
                data: {'reading_meter' : $('input[name="reading_meter"]').val(), customer_id: $('#acc_num').text()},
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
})