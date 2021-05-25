$(document).ready(function(){

    $("#save-billing").on('click', function(e){
        e.preventDefault();
        $('#save-billing').html('<i class="far fa-spinner fa-spin"></i>&nbsp; Processing ...');
        

        $('#save-billing').html('<i class="far fa-check"></i>&nbsp; Done');
    });

    $('#meter_reading').on('keyup', function(){
        if(parseFloat($(this).val()) > parseFloat($('#meter-reading').val()))
        {
            const meter_consumption = parseFloat($(this).val()) - parseFloat($('#meter-reading').val());
            const amount_consumption = (meter_consumption <= 10 ? 65 : (((meter_consumption - 10) * 10) + 65));
            $('#consumption').val(meter_consumption);
            $('#amount').val(amount_consumption);
            const total = ((parseFloat($('#surcharge_amount').val()) + amount_consumption) + parseFloat($('#meter-ips').val()))
            $('#total').val(total);
            $('#save-billing').prop('disabled', false);
        }
    });
});