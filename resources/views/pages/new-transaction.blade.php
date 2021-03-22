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
<h3 class="mt-5 mb-4 text-center">New Transaction</h3>

<form action="{{route('admin.search-customer')}}" method="get" class="row g-2 justify-content-center">
    
    <div class="col-12 col-md-6 col-lg-5 col-xl-4 mb-2">

        <input type="text" name="account_number" class="form-control @error('account_number') is-invalid @enderror" id="" value="{{old('account_number')}}" placeholder="Search Account Number" required>
        @error('account_number')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>

    <div class="col-12 col-md-2">
       <button type="submit" class="btn btn-primary w-100"><i data-feather="search" class="feather-16"></i> Search </button>
    </div>
</form>

@if(isset($customer))

<div class="row">
    <div class="col col-md-5 col-lg-4 col-xl-3">
        <div class="card">
            <div class="card-header">
                <i data-feather="user" class="feather-16"></i> Customer Information
            </div>
            <div class="card-body">
            <h5 class="card-title">{{$customer->fullname()}}</h5>
            <p class="card-text mb-1"><small class="text-muted">Address:</small> {{$customer->address()}}</p>
            <p class="card-text mb-1"><small class="text-muted">Connection type:</small> {{$customer->connectionType()}}</p>
            <p class="card-text"><small class="text-muted">Purchase Meter Option:</small> {{$customer->purchaseOption()}}</p>
            
            </div>
        </div>
    </div>
    <div class="col col-md-7 col-lg-8 col-xl-9">

        <div class="card">
           
            <div class="card-header">
                <i data-feather="plus" class="feather-16"></i> New Transaction
            </div>
            <div class="card-body">
                <form action="{{route('admin.transactions.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="customer_id" value="{{$customer->account_number}}">
                        <div class="col col-md-12 col-lg-7 col-xl-6 ">
                            <h6>Type of Service</h6>
                            <hr>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type_of_service" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                New Water Application
                                </label>
                            </div>
                    
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type_of_service" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Transfer of Meter Location
                                </label>
                            </div>

                            {{-- Transfer of meter location options --}}
                            <div class="sub-category">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault1" id="flexRadioDefault2" checked>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Same Household
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault1" id="flexRadioDefault2" checked>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Different Household
                                    </label>
                                </div>
                            </div>
                        



                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type_of_service" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Reconnection
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type_of_service" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Disconnection
                                </label>
                            </div>

                            {{-- Disconnection options --}}
                            <div class="sub-category">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault2" id="flexRadioDefault2" checked>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Voluntary Request from account holder
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault2" id="flexRadioDefault2" checked>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Disconnection Order from waterworks
                                    </label>
                                </div>
                                <div class="row sub-category">
                                    <div class="col">
                                        <label for="" class="mt-2">Reason:</label>
                                        <select class="form-select mb-2 " aria-label="Default select example">
                                            <option selected>-Please select-</option>
                                            <option value="1">Long overdue</option>
                                            <option value="2">Unattended leaking</option>
                                            <option value="3">Etc.</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row sub-category mb-3">
                                    <div class="col">
                                        <div class="">
                                            <small for="exampleFormControlTextarea1" class="form-label text-muted">Applicable only if "Etc."" is selected as the reason</small>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type_of_service" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Change of Meter
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type_of_service" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Others
                                </label>
                            </div>
                            <div class="row sub-category">
                                <div class="col">
                                    <label for="">Details of Request:</label>
                                    <select class="form-select mb-2 " aria-label="Default select example">
                                        <option selected>--Please select--</option>
                                        <option value="1">Leaking / damage line</option>
                                        <option value="2">No Water</option>
                                        <option value="2">Low Pressure</option>
                                        <option value="3">Etc.</option>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="row sub-category mb-3">
                                <div class="col">
                                    <div class="">
                                        <small for="exampleFormControlTextarea1" class="form-label text-muted">Applicable only if "Etc."" is selected as the detail of request</small>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-12 col-lg-5 col-xl-6">
                            <h6>Additional Remarks / Description</h6>
                            <hr>
                            <textarea class="form-control mb-3" name='remarks' id="exampleFormControlTextarea1" rows="3"></textarea>

                            <label for="inputAddress" class="form-label">Schedule</label>
                            <input type="date"  name='schedule' class="form-control mb-3" id="inputAddress" placeholder="1234 Main St">
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