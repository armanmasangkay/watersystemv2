$(document).ready(async() => {
    let water_rates_value = await fetch('/admin/water-rate');
    water_rates_value = await water_rates_value.json();

    async function setWaterRates(){
        let water_types = document.getElementById('type');
        let water_rates = await water_rates_value;

        for(let i = 0 ; i < water_rates.data.reverse().length; i++)
        {
            let option = document.createElement('option');
            option.text = water_rates.data[i].type;
            option.value = water_rates.data[i].id;
            water_types.add(option,0);
        }
    }

    async function WaterTypeChangeValue(){
        let water_rates = await water_rates_value;
        let water_types = document.getElementById('type');
        let min_rate = document.getElementById('min_rate');
        let excess_rate = document.getElementById('excess_rate');

        min_rate.value = Math.round(water_rates.data[water_types.value - 1].min_rate * 100);
        excess_rate.value = Math.round(water_rates.data[water_types.value - 1].excess_rate * 100);
    }

    function AddDangerBorder(elementId)
    {
        let element = document.getElementById(elementId);
        element.classList.add("border", 'border-danger');
    }

    function RemoveBorders(){
        if(this.type.classList.contains('border')){
            this.type.classList.remove('border', 'border-danger')
        }
        if(this.min_rate.classList.contains('border')){
            this.min_rate.classList.remove('border', 'border-danger')
        }
        if(this.excess_rate.classList.contains('border')){
            this.excess_rate.classList.remove('border', 'border-danger')
        }
    }

    setWaterRates();

    document.getElementById('type').onchange = () => {
        if(document.getElementById('type').value === ""){
            document.getElementById('min_rate').value = "";
            document.getElementById('excess_rate').value = "";
        }
        else
        {
            WaterTypeChangeValue();
        }
    }


    this.water_rate_form.addEventListener('submit', async (e) => {
        e.preventDefault();
        let url = this.water_rate_form.getAttribute('action');
        let formData =new FormData(this.water_rate_form);

        let response = await fetch(url,{
            method: 'post',
            body: formData
        });

        response = await response.json();

        RemoveBorders();

        if(response.updated == true){
            Swal.fire('Great!',response.message,'success').then(function(result){
                if(result.isConfirmed)
                {
                    window.location.reload();
                }
            })
        }else{
            let keys = Object.keys(response.errors)
            for(key of keys){
                AddDangerBorder(key)
            }
        }
    })


})
