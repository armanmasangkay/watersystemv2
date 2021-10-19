@extends('field-personnel.layout.main')

@section('title', 'Lists of Unread Meter')

@section('content')

@if(count($customers) > 0)
<h5 class="text-secondary h5 mt-3"><i data-feather="align-right" class="mb-1 feather-18 me-1"></i> Unread Meter(s)</h5>
@endif
@forelse($customers as $customer)
<div class="card my-2">
    <div class="card-header">
        <a href="{{ route('admin.reader.search', ['account_number' => $customer->account_number]) }}" class="text-secondary text-decoration-none"><strong>ACC. NO: <span class="text-primary">{{$customer->account_number}}</span></strong></a>
    </div>
    <div class="card-body">
        <strong>Name: {{$customer->firstname . ' ' .$customer->middlename. ' '.$customer->lastname}}</strong></br>
        <strong>Address: {{$customer->address()}}</strong>
    </div>
</div>
@empty
<div class="border pt-4 pb-3 mt-5 mb-5 rounded">
    <h4 class="text-center"><i data-feather="search" class="me-1 mb-1 feather-30"></i> No records to show</h4>
</div>
@endforelse
<script src="{{ asset('assets/js/form-search-animation.js') }}" defer></script>
<script src="{{ asset('assets/js/fieldMeterReading.js') }}" defer></script>
@endsection