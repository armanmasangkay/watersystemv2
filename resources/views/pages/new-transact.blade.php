@extends('layout.main')

@section('title', 'New Transaction')


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
<h3 class="mt-5 h4 mb-4 text-left">NEW CONNECTIONS</h3>

<form action="{{route('admin.search-customer')}}" method="get" class="row g-2 form-inline">
    
    <div class="col-12 col-md-6 col-lg-5 col-xl-4 mb-2 pr-1">

        <input type="text" name="account_number" class="form-control @error('account_number') is-invalid @enderror" id="" value="{{old('account_number')}}" placeholder="Search Account Number" required>
        @error('account_number')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>

    <div class="col-12 col-md-2">
       <button type="submit" class="btn btn-primary"><i data-feather="search" class="feather-16"></i> Search </button>
    </div>
</form>

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
                <i data-feather="plus" class="feather-16"></i> New Transaction
            </div>
            <div class="card-body p-4">
                <form action="{{route('admin.transactions.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="customer_id" value="{{$customer->account_number}}">
                        <div class="col col-md-12 col-lg-7 col-xl-6 ">
                            <h6>Additional Remarks / Description</h6>
                            <textarea class="form-control mb-3" name='remarks' id="exampleFormControlTextarea1" rows="3"></textarea>

                            <h6 for="" class="form-label">Landmark</h6>
                            <input type="text"  name='schedule' class="form-control mb-3" id="inputAddress" placeholder="1234 Main St">

                            <h6 for="" class="form-label mb-1">Verify contact number</h6>
                            <small class="text-danger pt-0">Please change the contact number if current number is no the same.</small>
                            <input type="number"  name='schedule' class="form-control mb-3" id="inputAddress" placeholder="09xxxxxxxxx">

                            <h6 for="" class="form-label">Initial building inspection schedule</h6>
                            <input type="date"  name='schedule' class="form-control mb-3" id="inputAddress" placeholder="dd/mm/yyyy">

                            <h6 for="" class="form-label">Initial water works schedule</h6>
                            <input type="date"  name='schedule' class="form-control mb-3" id="inputAddress" placeholder="dd/mm/yyyy">

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