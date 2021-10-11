@extends('layout.main')
@section('title', 'Request Services | Payment')

@section('content')

<h5 class="text-secondary h4 mt-5"><i data-feather="align-right" class="mb-1 feather-30 me-1"></i> Lists of Request Services Pending for Payment</h5>
<div class="card shadow-sm mt-2">
    <div class="card-header px-2 bg-white pt-1 pb-0">
        <div class="row">
            <div class="col-md-9 py-0">
                @include('templates.form-search-account')
            </div>
            <div class="col-md-3 pt-md-2">
            @if(count($services) > 0)
                <a href="{{ route('admin.services-payment') }}" class="btn btn-secondary float-md-end" style="height: 45px; padding-top: 10px;">Refresh</a>
            @endif
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive p-0">
            <table class="table mb-0" style="min-width: 1200px !important">
                <thead class="bg-light">
                    <tr>
                        <td class="border-bottom pt-3 pb-3 text-secondary"><strong><i data-feather="bar-chart-2" class="mx-1 text-primary" width="18"></i> ACCOUNT NO</strong></td>
                        <td class="border-bottom pt-3 pb-3 text-secondary"><strong><i data-feather="user" class="mx-1 text-primary" width="18"></i> CLIENT NAME</strong></td>
                        <td class="border-bottom pt-3 pb-3 text-secondary"><strong><i data-feather="activity" class="mx-1 text-primary" width="18"></i> REQUEST TYPE</strong></td>
                        <td class="border-bottom pt-3 pb-3 text-secondary"><strong><i data-feather="calendar" class="mx-1 text-primary" width="18"></i> DATE OF REQUEST</strong></td>
                        <td class="border-bottom pt-3 pb-3 text-secondary"><strong><i data-feather="activity" class="mx-1 text-primary" width="20"></i> ACTIONS</strong></td>
                    </tr>
                </thead>
                <tbody>
                    @if(count($services) > 0)
                    @foreach ($services as $service)
                        <tr>
                            <td class="pt-2 pb-2 ps-3">{{ $service->customer->account_number }}</td>
                            <td class="pt-2 pb-2 ps-3">{{ $service->customer->fullname() }} </td>
                            <td class="pt-2 pb-2 ps-3">{{ $service->prettyServiceType() }}</td>
                            <td class="pt-2 pb-2 ps-3">{{ \Carbon\Carbon::parse($service->created_at)->format('F d, Y') }}</td>
                            <td class="d-flex justify-content-start py-2">
                                <button type="submit" class="border-0 bg-white text-primary py-0" data-bs-toggle='modal' data-bs-target='#servicePaymentModal' data-id="{{ $service->id }}" acc-id="{{ $service->customer->account_number }}" id="payment"><i data-feather="user-check" width="18" class="mb-1"></i>&nbsp; Pay</button>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="{{ count($services) > 0 ? 'pt-2 pb-2 px-2 bg-light' : 'pt-1 pb-1 px-2 bg-white' }}">
                <div class="pt-2 px-2 pb-1">
                    @if(count($services) > 0)
                    {{ $services->render() }}
                    @else
                    <h6 class="text-center text-secondary">No records to display</h6>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('templates.servicePaymentModal')
@endsection

@section('custom-js')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{ asset('assets/js/servicePayment.js') }}" defer></script>

@endsection