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

<h3 class="mt-5 h4 mb-4 text-left">APPLICATION FOR TRANSFER OF METER</h3>
@include('templates.form-search-account')

@if(isset($customer))

<div class="row mb-5 mt-2">
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
                        <div class="col-md-12">
                            <input type="radio" name="dif_hh">&nbsp; Different Household</br>
                            <input type="radio" name="same_hh" class="mt-3">&nbsp; Same Household
                        </div>
                    </div>
                    <div class="row mt-4">
                        <input type="hidden" name="customer_id" value="{{$customer->account_number}}">
                        <div class="col col-md-12 col-lg-7 col-xl-6 ">
                            <h6 class="form-label mb-1">Additional Remarks / Description</h6>
                            <small class="text-info pt-0">You may update this information if it has changed.</small>
                            <textarea class="form-control f-control mb-3" name='remarks' id="exampleFormControlTextarea1" rows="3"></textarea>

                            <h6 for="" class="form-label mb-1">Landmark</h6>
                            <small class="text-info pt-0">You may update this information if it has changed.</small>
                            <input type="text"  name='schedule' class="form-control f-control mb-3" id="inputAddress" placeholder="1234 Main St">

                            <h6 for="" class="form-label mb-1">Verify contact number</h6>
                            <small class="text-info pt-0">You may update this information if it has changed.</small>
                            <input type="number"  name='schedule' class="form-control f-control mb-3" id="inputAddress" placeholder="09xxxxxxxxx">

                            <h6 for="" class="form-label">Initial building inspection schedule</h6>
                            <input type="date"  name='schedule' class="form-control f-control mb-3" id="inputAddress" placeholder="dd/mm/yyyy">

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

@section('custom-js')
<script>
    $(document).ready(function(){
        $('.f-control').attr('disabled', true);
        $('.text-info').css('display', 'none');
        $('input[name="same_hh"]').prop('checked', true);

        $('input[name="same_hh"]').on('click', function(){
            $('.f-control').attr('disabled', true);
            $('.text-info').css('display', 'none');
            $('input[name="dif_hh"]').prop('checked', false);
            $(this).attr('checked', true);
        })

        $('input[name="dif_hh"]').on('click', function(){
            $('.f-control').attr('disabled', false);
            $('.text-info').css('display', 'block');
            $('input[name="same_hh"]').prop('checked', false);
            $(this).attr('checked', true);
        })
    })
</script>
@endsection