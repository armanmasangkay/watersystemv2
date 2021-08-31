

$(document).ready(function(){

    var nxt_mtr = 0;

    $('#edit_carbon_date_billing').datepicker({ 
        autoclose: true, 
        todayHighlight: true,
    }).datepicker('update', new Date());

    var date =  new Date($('#edit_carbon_date_billing').val())
    var newDate = date.toDateString().split(' '),
        cleanDate = date.toLocaleString('default', { month: 'long' }) + ' ' + newDate[2] + ', ' + newDate[3]

    $('#edit_carbon_date_billing').val(cleanDate)

    $('#edit_carbon_date_billing').change(function(){
        var date =  new Date($(this).val())
        var newDate = date.toDateString().split(' '),
            cleanDate = date.toLocaleString('default', { month: 'long' }) + ' ' + newDate[2] + ', ' + newDate[3]
            numDate = new Date($(this).val()).toLocaleString().split(',')[0]

        $('#edit_carbon_date_billing').val(cleanDate)
        $('#edit_reading_date').val(numDate)
    })

    function updateBill()
    {
        let editForm = document.getElementById('edit-billing-form')
        let actionURI = editForm.getAttribute('action')


        if($('#edit_reading_date').val() != '')
        {
            $('#update-billing').html('<i class="far fa-spinner fa-spin"></i>&nbsp; Processing ...');
            $('#update-billing').prop('disabled', true);

            let data = $('#edit-billing-form').serialize();

            $.ajax({
                type: 'POST',
                url: actionURI,
                data: data,
                success: function(response){
                    console.log(response)
                    if(response.created == true){
                        $('#current-month').prop('disabled', true);
                        $('#next-month').prop('disabled', true);
                        $('#update-billing').html('<i class="far fa-check"></i>&nbsp; Done!');

                        Swal.fire('Update Successfull!','Billing updates for client '+ $('input[name="customer_id"]').val() +' was created!','success').then(function(result){
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
    }

    $("#edit-billing-form").on('submit', function(e){
        e.preventDefault();

        if(parseInt($('#edit_reading_meter').val()) >= parseInt($('#edit_meter_reading_bal').val()))
        {
            if(nxt_mtr == 0)
            {
                updateBill()
            }
            else if(parseInt($('#edit_reading_meter').val()) <= nxt_mtr)
            {
                updateBill()
            }
            else
            {
                Swal.fire('Ooops!',"Edited meter reading cannot be greater than the next meter reading!")
                $('#update-billing').prop('disabled', true);
            }
        }
        else
        {
            Swal.fire('Ooops!',"Edited meter reading cannot be less than the previous meter reading!")
            $('#update-billing').prop('disabled', true);
        }

    });

    $(document).on('click', '#edit', function(){

        var id = $(this).attr('data-id')

        const max_range = parseFloat($('input[name="max_range"]').val());
        const min_rates = parseFloat($('input[name="min_rates"]').val());
        const excess_rate = parseFloat($('input[name="excess_rate"]').val());
        const payment_or = $('input[name="or_num"]').val();
        const balance = parseFloat($('input[name="cur_balance"]').val());
        const surcharge_rate = parseFloat($('input[name="surcharge"]').val());
        const meter_ips = parseFloat($('input[name="meter_ips"]').val());

        const surcharge = (payment_or != null ? (balance * surcharge_rate) : 0.00);

        $.ajax({
            method: 'POST',
            url: '/admin/consumer-ledger/billing/transaction/' + id,
            data: {_token: $('input[name="_token"]').val(), customer_id : $('#account_number').val()},
            success: function(responseData){

                if(responseData.getBill == true){
                    
                    $('input[name="edit_cur_balance"]').val(format_number(responseData.balance))
                    $('input[name="edit_meter_reading_bal"]').val(responseData.meter)

                    responseData.bal.forEach(element => {

                        var period = element.period_covered
                        var result = (period != 'Beginning Balance') ?? period.split('-')
                        var year = (period != 'Beginning Balance') ?? result[1].split(',')
                        var date =  new Date(element.reading_date),
                            newDate = date.toDateString().split(' '),
                            cleanDate = date.toLocaleString('default', { month: 'long' }) + ' ' + newDate[2] + ', ' + newDate[3]
                        var date = new Date(element.reading_date).toLocaleString().split(',')[0]

                        const total_consumption = ((element.reading_consumption - max_range) * excess_rate) + min_rates;
                        const amount_consumption = element.reading_consumption <= max_range ? min_rates : total_consumption;

                        $('input[name="edit_from"]').val((period == 'Beginning Balance') ? 'Beginning Balance' : result[0] + '' + year[1] )
                        $('input[name="edit_to"]').val((period == 'Beginning Balance') ? '' : result[1] + '' + year[1] )
                        $('input[name="edit_curr_transaction_id"]').val(element.id)
                        $('input[name="edit_date"]').val(cleanDate)
                        $('#edit_carbon_date_billing').val(cleanDate)
                        $('input[name="edit_reading_date"]').val(date) 
                        $('input[name="current_meter"]').val(element.reading_meter)
                        $('input[name="edit_amount"]').val(amount_consumption.toFixed(2))
                        $('input[name="edit_consumption"]').val(element.reading_consumption)
                        $('input[name="edit_consumpt_amount"]').val(element.billing_amount.toFixed(2))
                        $('input[name="edit_surcharge_amount"]').val(element.billing_surcharge.toFixed(2))
                        $('input[name="edit_meterIPS"]').val(element.billing_meter_ips.toFixed(2))

                        // $('input[name="edit_amount"]').val(format_number(((period != 'Beginning Balance') ? (parseFloat(element.billing_total) - parseFloat(element.billing_surcharge)) : 0)))

                        $('#edit_total').val(format_number(element.billing_total));
                    })
                    
                    $('input[name="edit_meter_reading_bal"]').val(responseData.meter) 

                    $('#editBillingSetupModal').modal('show')
                    nxt_mtr = responseData.nxt_mtr
                    
                }
                else{
                    Swal.fire('Ooops!',"There was an error on updating the consumer's bill!")
                }
            }
        })
    })

    $('#edit_reading_meter').on('keyup', function(){

        if($(this).val() != '')
        {
            if(parseInt($(this).val()) >= parseInt($('#edit_meter_reading_bal').val()))
            {
                if(parseInt($(this).val()) > parseInt($('#edit_meter-reading').val()))
                {
                    if(nxt_mtr == 0 || parseInt($(this).val()) <= nxt_mtr)
                    {
                        computeAdditionalBilling()
                    }
                    else
                    {
                        $('#update-billing').prop('disabled', true);
                    }
                }
                else
                {
                    computeDeductionBilling()
                }
                $('#update-billing').prop('disabled', false);
            }
            else
            {
                $('#update-billing').prop('disabled', true);
            }
        }
        else{
            $('#update-billing').prop('disabled', true);
            $('#edit_consumption').val(0);
            $('#edit_surcharge_amount').val('0.00');
            $('#edit_amount').val('0.00');
            $('#edit_total').val('0.00');
        }
    });

    function computeAdditionalBilling()
    {
        const max_range = parseFloat($('input[name="edit_max_range"]').val());
        const min_rates = parseFloat($('input[name="edit_min_rates"]').val());
        const excess_rate = parseFloat($('input[name="edit_excess_rate"]').val());
        const payment_or = $('input[name="edit_or_num"]').val();
        const balance = parseFloat($('input[name="edit_cur_balance"]').val());
        const surcharge_rate = parseFloat($('input[name="edit_surcharge"]').val());
        const meter_ips = parseFloat($('input[name="edit_meter_ips"]').val());

        const surcharge = (parseFloat($('#edit_surcharge_amount').val()) > 0 ? ((amount_consumption + balance) * surcharge_rate) : 0.00)

        const meter_consumption = parseInt($('#edit_reading_meter').val()) - parseInt($('#edit_meter-reading').val());
        const total_consumption = ((meter_consumption - max_range) * excess_rate) + min_rates;
        const amount_consumption = meter_consumption <= max_range ? min_rates : total_consumption;
        
        $('#edit_consumption').val(meter_consumption.toFixed(2));
        $('#edit_surcharge_amount').val(surcharge.toFixed(2));
        $('#edit_amount').val(amount_consumption.toFixed(2));

        const total = ((surcharge + balance) + (meter_ips + amount_consumption));

        $('#edit_total').val(total.toFixed(2));
        $('#edit_save-billing').prop('disabled', false);
    }

    function computeDeductionBilling()
    {
        const max_range = parseFloat($('input[name="edit_max_range"]').val())
        const min_rates = parseFloat($('input[name="edit_min_rates"]').val())
        const excess_rate = parseFloat($('input[name="edit_excess_rate"]').val())
        const payment_or = $('input[name="edit_or_num"]').val();
        const balance = parseFloat($('input[name="edit_cur_balance"]').val())
        const surcharge_rate = parseFloat($('input[name="edit_surcharge"]').val())
        const meter_ips = parseFloat($('input[name="edit_meter_ips"]').val())

        const meter_consumption = (parseInt($('#edit_meter_reading_bal').val()) > parseInt($('#edit_reading_meter').val())) ? 
                                (parseInt($('#edit_meter_reading_bal').val()) - parseInt($('#edit_reading_meter').val())) : 
                                (parseInt($('#edit_reading_meter').val()) - parseInt($('#edit_meter_reading_bal').val()))
                                
        const total_consumption = ((meter_consumption - max_range) * excess_rate) + min_rates
        const amount_consumption = meter_consumption <= max_range ? min_rates : total_consumption

        const surcharge = (parseFloat($('#edit_surcharge_amount').val()) > 0 ? ((amount_consumption + balance) * surcharge_rate) : 0.00)
        
        $('#edit_consumption').val(meter_consumption);
        $('#edit_surcharge_amount').val(surcharge.toFixed(2));  
        $('#edit_amount').val(amount_consumption.toFixed(2));

        const total = ((surcharge + balance) + (meter_ips + amount_consumption));

        $('#edit_total').val(total.toFixed(2));

        $('#edit_save-billing').prop('disabled', false);
    }

    $('#edit_carbon_date_billing').change(function(){
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
})