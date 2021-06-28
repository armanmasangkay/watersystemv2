$(document).ready(async() => {
    let surcharge_value = await fetch('/admin/surcharge');
    surcharge_value = await surcharge_value.json();

    this.surcharge_rate.value = Math.round(surcharge_value.data[0].rate * 100);

    this.surcharge_form.addEventListener('submit', async(e) =>{
        e.preventDefault();
        let uri = this.surcharge_form.getAttribute('action');
        let formData = new FormData(this.surcharge_form)

        let response = await fetch(uri, {
            method: 'post',
            body: formData
        });

        response = await response.json();

        if(response.updated == true){
            Swal.fire('Great!',response.message,'success').then(function(result){
                if(result.isConfirmed)
                {
                    window.location.reload();
                }
            })
        }else{
            this.surcharge_rate.classList.add('border', 'border-danger');
        }
    })
})

