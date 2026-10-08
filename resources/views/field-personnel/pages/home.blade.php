@extends('field-personnel.layout.main')

@section('title', 'Home')

@section('content')
<h4 class="text-center mt-5">WELCOME ! <span class="text-primary ms-1">{{ Auth::user()->name }}</span></h4>
<h2 class="text-center mt-3" id="date"></h2>
<h3 class="text-center" id="time"></h3>


<div class="row justify-content-center">
    <form class="col-10 row" id="filter_barangay" action="{{ route('admin.filter') }}" method="post">
        @csrf
        <div class="form-group mt-2 col-md-4">
            <input type="hidden" name="barangay" id="barangay">
            <select class="form-select" id="brgy-dropdown">
            </select>
            <small id="error-barangay" class="text-danger" hidden ></small>
        </div>
        <div class="form-group mt-2 col-md-4">
            <input type="hidden" name="purok" id="purok">
            <select class="form-select" id="purok-dropdown" >
            </select>
            <small id="error-purok" class="text-danger" hidden></small>
        </div>
        <div class="mt-2 col-md-4 d-grid gap-2">
          <button class="btn btn-primary" type="submit" id="filter_btn">Filter</button>
        </div>
      </form>
</div>

<!-- Button trigger modal -->

  <!-- Modal -->
  <div class="modal fade modal-fullscreen" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Reminder:</strong> Kindly click the table row to view customer information.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <table  class=" table table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <td>Client</td>
                        <td>Account No</td>
                    </tr>
                </thead>
                <tbody id="table_data">
                    <tr>
                        <td>June Vic Cadayona</td>
                        <td>12345</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<script>
    filter_barangay.addEventListener('submit', async(e)=>{
        e.preventDefault();

        function AddError(elementId, message)
        {
            $("#error-"+elementId).prop('hidden',false);
            $("#error-"+elementId).html(message)
            $("select[id='"+elementId+"-dropdown']").addClass('is-invalid')
        }

        function RemoveError(){
            let elmts = document.getElementsByTagName("input");
            let elmtsLength = elmts.length;
            for (var i = 0; i < elmtsLength; i++) {
                if($("#error-"+elmts[i].name == elmts.name)){
                    $("#error-"+elmts[i].name).prop('hidden',true);
                    $("select[id='"+elmts[i].name+"-dropdown']").removeClass('is-invalid')
                }
            }
        }

        function CreateURL(account_number){
            if(this.location.port === '')
            {
                return `${location.protocol}//${this.location.hostname}/admin/field-personnel/meter-reading/search/consumer?account_number=${account_number}`
            }else{
                return `${location.protocol}//${this.location.hostname}:${this.location.port}/admin/field-personnel/meter-reading/search/consumer?account_number=${account_number}`
            }
        }

        filter_btn.innerText = "Filtering..."
        filter_btn.disabled = true

        let url = filter_barangay.getAttribute('action');
        let formData =new FormData(filter_barangay);

        let response = await fetch(url,{
            method: 'post',
            body: formData
        });


        response = await response.json();
        RemoveError();

        filter_btn.innerText = "Filter"
        filter_btn.disabled = false
        if(response.filtered == true){
            modal_title.innerText = `${barangay.value} - ${purok.value}`;
            $('#staticBackdrop').modal("show");
            if(response.data.length == 0){
                table_data.innerHTML = "<tr class='text-center'> <td colspan='2'>No data</td> </tr>"
            }else{
                table_data.innerHTML = ""
                let count = 0
                while(count < response.data.length){
                table_data.innerHTML += `<tr onclick="location.href='${CreateURL(response.data[count].account_number)}'">
                                                                <td>${response.data[count].firstname} ${response.data[count].lastname}</td>
                                                                <td>${response.data[count].account_number}</td>
                                                            </tr>`
                    count++
                }
            }

        }else{
            let keys = Object.keys(response.errors)

            for(key of keys){
                AddError(key, response.errors[key]);
            }
        }

    })

    startTime()
    function startTime() {
        const today = new Date();
        let h = today.getHours();
        let m = today.getMinutes();
        let s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('time').innerHTML =  h + ":" + m + ":" + s;
        setTimeout(startTime, 1000);
    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }

    var date =  new Date()
    var newDate = date.toDateString().split(' '),
        cleanDate = date.toLocaleString('default', { month: 'long' }) + ' ' + newDate[2] + ', ' + newDate[3]

    document.getElementById('date').innerHTML = cleanDate
</script>
@endsection

@section('custom-js')
<script src="{{ asset('assets/js/location.js') }}" defer></script>
<script src="{{ asset('assets/js/toggle-side-nav.js') }}" defer></script>
@endsection
