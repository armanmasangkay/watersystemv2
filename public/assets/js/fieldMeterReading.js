function darken_screen(yesno)
{
    if(yesno == true){
        document.querySelector('.screen-darken').classList.add('active')
    }
    else if(yesno == false){
        document.querySelector('.screen-darken').classList.remove('active')
    }
}

function close_offcanvas()
{
    darken_screen(false)
    document.querySelector('.mobile-offcanvas.show').classList.remove('show')
    document.body.classList.remove('offcanvas-active')
}

function show_offcanvas(offcanvas_id)
{
    darken_screen(true)
    document.getElementById(offcanvas_id).classList.add('show')
    document.body.classList.add('offcanvas-active')
}

function show_search(yesno)
{
    if(yesno == true){
        document.querySelector('.form-search').classList.remove('hidden')
        document.querySelector('.form-search').classList.add('active')
        document.querySelector('.close').classList.add('show')
        document.querySelector('.search').classList.add('hidden')
    }
    else if(yesno == false){
        document.querySelector('.form-search').classList.remove('active')
        document.querySelector('.form-search').classList.add('hidden')
        document.querySelector('.close').classList.remove('show')
        document.querySelector('.search').classList.remove('hidden')
    }
}

document.addEventListener("DOMContentLoaded", function(){
    document.querySelectorAll('[data-trigger]').forEach(function(everyElement){
        let offcanvas_id = everyElement.getAttribute('data-trigger');
        everyElement.addEventListener('click', function(e){
            e.preventDefault()
            show_offcanvas(offcanvas_id)
        })
    })

    document.querySelectorAll('.btn-close').forEach(function(everyButtton){
        everyButtton.addEventListener('click', function(e){
            close_offcanvas()
        })
    })

    document.querySelector('.screen-darken').addEventListener('click', function(e){
        close_offcanvas()
    })

    document.querySelector('.search').addEventListener('click', function(e){
        show_search(true)
    })

    document.querySelector('.close').addEventListener('click', function(e){
        show_search(false)
    })
})

$(document).ready(function(){

    $("#billing-form").on('submit', function(e){
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
                        $('#save-billing').html('<i class="far fa-check"></i>&nbsp; Done!');

                        Swal.fire('Billing Successfull!','New billing for client '+ $('input[name="customer_id"]').val() +' was created!','success').then(function(result){
                            if(result.isConfirmed)
                            {
                                window.location.reload();
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