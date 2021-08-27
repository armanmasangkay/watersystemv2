$(document).ready(async()=>{


    function AddError(elementId, message)
    {
        $("#error-"+elementId).prop('hidden',false);
        $("#error-"+elementId).html(message)
        $("input[name='"+elementId+"']").addClass('is-invalid')
    }

    function RemoveError(){
        let elmts = document.getElementsByTagName("input");
        let elmtsLength = elmts.length;
        for (var i = 0; i < elmtsLength; i++) {
            if($("#error-"+elmts[i].name == elmts.name)){
                $("#error-"+elmts[i].name).prop('hidden',true);
                $("input[name='"+elmts[i].name+"']").removeClass('is-invalid')
            }
        }
    }



    registration_form.addEventListener('submit', async(e)=>{
        e.preventDefault();
        let url = this.registration_form.getAttribute('action');
        let formData =new FormData(this.registration_form);

        let response = await fetch(url,{
            method: 'post',
            body: formData
        });


        response = await response.json();
        RemoveError();
        if(response.created == true){
            Swal.fire('Great!','New customer has been added','success').then(function(result){
                if(result.isConfirmed)
                {
                    window.location.reload();
                }
            })
        }else{
            let keys = Object.keys(response.errors)

            for(key of keys){
                AddError(key, response.errors[key]);
            }
        }
    });

});
