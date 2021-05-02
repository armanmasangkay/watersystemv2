@extends('layout.main')

@section('title', 'New Connection')


@section('content')
@if(session('created'))
<div class="row justify-content-center mt-2">
    <div class="col">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Great!</strong> {{session('message')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif
<h3 class="mt-5 h4 mb-4 text-left">{{ $search_heading }}</h3>
@include('templates.form-search-account')

@if(isset($customer))

<div class="row mb-5">
    <div class="col col-md-5 col-xl-3">
        <div class="card">
            <div class="card-header">
                <i data-feather="user" class="feather-16"></i> Customer Information
            </div>
            <div class="card-body">
            <h5 class="card-title text-primary"><strong>{{ strtoupper($customer->fullname()) }}</strong></h5>
            <p class="card-text mb-1 pt-2"><small class="text-muted">Complete Address:</small> {{$customer->address()}}</p>
            <p class="card-text mb-1"><small class="text-muted">Connection type:</small> {{$customer->connectionType()}}</p>
            <p class="card-text"><small class="text-muted">Purchase Meter Option:</small> {{$customer->purchaseOption()}}</p>

            </div>
        </div>
    </div>
    <div class="col col-md-7 col-xl-9">

        <div class="card">

            <div class="card-header">
                <i data-feather="info" class="feather-16"></i> Additional Information
            </div>
            <div class="card-body p-4">
                <form action="{{route('admin.transactions.store')}}" method="post">
                    @csrf
                    <div class="row">
                    <input type="hidden" name="type_of_service" value="New Connections">
                        <input type="hidden" name="customer_id" value="{{$customer->account_number}}">
                        <input type="hidden" name="status" value="mto_approval">
                        <div class="col col-md-12 col-lg-7 col-xl-6 ">

                            <h6>Additional Remarks / Description</h6>
                            <textarea class="form-control mb-3" name='remarks' id="exampleFormControlTextarea1" rows="3" >{{ session('remarks') }}</textarea>

                            @error('landmarks')
                                <small class="text-danger mb-3">{{ $message }}</small>
                            @enderror
                            <h6 for="" class="form-label">Landmark</h6>
                            <input type="text"  name='landmarks' class="form-control mb-3" id="inputAddress" placeholder="1234 Main St" value="{{ session('landmarks') }}">

                            <h6 for="" class="form-label mb-1">Verify contact number</h6>
                            <small class="text-info pt-0">You may update this information if it has changed.</small>
                            @error('contact_number')
                                <small class="text-danger mb-3">{{ $message }}</small>
                            @enderror
                            <input type="number"  name='contact_number' class="form-control mb-3" id="inputAddress" placeholder="09xxxxxxxxx" value="{{session('contact_number')}}">


                            @error('building_inspection_schedule')
                                <small class="text-danger mb-3">{{ $message }}</small>
                            @enderror
                            <h6 for="" class="form-label">Initial building inspection schedule</h6>
                            <input type="date"  name='building_inspection_schedule' class="form-control mb-3" id="inputAddress" placeholder="dd/mm/yyyy" value="{{session('building_inspection_schedule')}}">

                            @error('water_works_schedule')
                                <small class="text-danger mb-3">{{ $message }}</small>
                            @enderror
                            <h6 for="" class="form-label">Initial water works schedule</h6>
                            <input type="date"  name='water_works_schedule' class="form-control mb-3" id="inputAddress" placeholder="dd/mm/yyyy" value="{{session('water_works_schedule')}}">

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endif













@endsection
