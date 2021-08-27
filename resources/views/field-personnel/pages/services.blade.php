@extends('field-personnel.layout.main')

@section('title', 'Meter Services')

@section('content')
    <div class="mt-3">
        <div class="row">
            <div class="col-12 col-sm-8 col-md-6 col-lg-6 form-search d-lg-block d-md-none hidden pt-1">
                <form action="{{ route('services-search-customer') }}" method="get" class="d-flex justify-content-between align-items-center mb-lg-0">
                    <input type="text" class="form-control" name="account_number" placeholder="Account no. or name">
                    <button class="btn btn-primary ms-1 d-flex justify-content-between align-items-center" id="close"><i data-feather="search" class="feather-18 me-1"></i> Search</button>
                </form>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger pb-0">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(isset($customer))
        <h6 class="text-secondary ps-1 d-block d-lg-none pt-2" style="font-size: 17px !important;"><strong>CLIENT : {{isset($customer)?strtoUpper($customer["org_name"])?strtoupper($customer["org_name"]):strtoupper($customer["fullname"]):''}}</strong></h6>
        <h6 class="text-secondary ps-1 d-block d-lg-none pb-2" style="font-size: 15px !important;"><strong>ACCOUNT NO : <span class="text-primary">{{ isset($customer) ? $customer["account"] : '' }}</span></strong></h6>
        @endif
        <div class="row">
            <div class="col-12 col-sm-8 col-md-6">
                <div class="card bg-white mt-md-2">
                    <div class="card-header pt-3 pb-2 bg-white d-none d-lg-block">
                        <h6 class="text-secondary d-flex justify-content-start align-items-center"><span>CLIENT &nbsp;:</span> <span class="text-primary ms-2">{{isset($customer)?strtoUpper($customer["org_name"])?strtoupper($customer["org_name"]):strtoupper($customer["fullname"]):''}}</span></h6>
                        <h6 class="text-secondary d-flex justify-content-start align-items-center"><span>ACC. # &nbsp; :</span> <span class="text-primary ms-2" id="acc_num">{{ isset($customer) ? $customer["account"] : '' }}</span></h6>
                    </div>
                    <div class="card-body pt-3 pb-2 px-3">
                        <form id="waterworks_form" action="{{ route('meter-services.store') }}" method="post">
                            @csrf
                            <p class="text-danger pt-1">Reminder: Fields with (*) is required.</p>
                            <h3 class="text-muted mt-4"><strong>Water Works Services </strong></h3>
                            <div class="row mt-4 mb-2 ps-4">
                                <p class="mb-0">Select service(s) <span class="text-danger">*</span></p>
                                <div class="ms-4">
                                    <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="radio" name="type_of_service" id="" value="request_for_transfer_of_meter" class="me-2 mt-1">Request for transfer of meter</h6>
                                    <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="radio" name="type_of_service" id="" value="change_of_meter" class="me-2 mt-1">Change of meter</h6>
                                    <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="radio" name="type_of_service" id="" value="change_of_ownership" class="me-2 mt-1">Change of ownership</h6>
                                    <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="radio" name="type_of_service" id="" value="disconnection"class="me-2 mt-1">Disconnection</h6>
                                    <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="radio" name="type_of_service" id="" value="repairs_of_damage_connection" class="me-2 mt-1">Repairs of damage connection (from main tone to meter only)</h6>
                                    <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="radio" name="type_of_service" id="" value="report_of_no_water_low_pressure" class="me-2 mt-1">Report of no water, low pressure</h6>
                                    <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="radio" name="type_of_service" id="" value="defective_meter_and_other_related_request" class="me-2 mt-1">Defective meter and other related request. (Except application for new connection and reconnection)</h6>
                                    <!-- <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="checkbox" name="" id="" class="me-2 mt-1"></h6>
                                    <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="checkbox" name="" id="" class="me-2 mt-1"></h6> -->
                                </div>
                            </div>
                            {{-- <button type="submit">sample</button> --}}
                        </form>
                    </div>
                </div>
                @if(!isset($customer))
                <div class="card px-3 mt-2">
                    <p class="text-info pt-3 info-txt"><i data-feather="info" class="feather-18 mb-1"></i> Note: Search customer then select service(s) to process your request</p>
                    <div class="row mt-1 parent mb-3 d-block d-lg-none" id="parent">
                        <div class="col-xs-12 d-flex justify-content-start align-items-center mt-2">
                            <button type="button" id="search" class="search btn btn-primary d-flex justify-content-between align-items-center"><i data-feather="search" class="feather-18 me-2"></i> Search Customer</button>
                        </div>
                    </div>
                </div>
                @endif
                @if(isset($customer))
                <div class="row mt-3">
                    <div class="col-xs-12 d-flex justify-content-start align-items-center mt-1">
                        <button class="btn btn-primary d-flex justify-content-between align-items-center" id="request_waterworks_btn" ><i data-feather="user-plus" class="feather-18 me-2"></i> Request Water Works</button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('custom-js')

<script>


    request_waterworks_btn.addEventListener('click', async(e)=>{
        // e.preventDefault();
        let data = new FormData(waterworks_form)
        data.append('account_number', acc_num.textContent)
        let url = waterworks_form.getAttribute('action');

        // data.forEach((datas) => console.log(datas));

        let response = await fetch(url,{
            method: 'post',
            body: data
        });

        response = await response.json();
        if(response.created == true){
            Swal.fire('Great!','New customer has been added','success').then(function(result){
                if(result.isConfirmed)
                {
                    window.location.reload();
                }
            })
        }else{
            Swal.fire('Something went wrong!','Please be sure to fill up all the required fields','error');
        }

    })
</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{ asset('assets/js/form-search-animation.js') }}" defer></script>

@endsection
