@extends('layout.main')

@section('title', 'New Transaction')


@section('content')

<h3 class="mt-3 text-center">New Transaction</h3>

<form action="{{route('admin.search-customer')}}" method="get" class="row g-2 justify-content-center">
    
    <div class="col-12 col-md-6 col-lg-5 col-xl-4 mb-2">

        <input type="text" name="account_number" class="form-control @error('account_number') is-invalid @enderror" id="" value="{{old('account_number')}}" placeholder="Search Account Number">
        @error('account_number')
        <div class="invalid-feedback">
            Account Number not found
        </div>
        @enderror
    </div>

    <div class="col-12 col-md-2 col-lg-2 col-xl-1 text-center">
       <button type="submit" class="btn btn-primary w-100">Search</button>
    </div>
</form>








        




@endsection