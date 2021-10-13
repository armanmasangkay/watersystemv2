@extends('layout.approval')

@section('title', 'Pending for Completion')


@section('content')
@include('templates.user')
   
@if($services->count()>0)
<div class="card mt-5 shadow-sm">
    <div class="card-header pb-1">
        <div class="row">
            <div class="col-md-8">
                <h4 class="text-left my-2"><i data-feather="check-square" class="mb-1 me-1"></i> Pending for Completion</h4>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.waterworks-request-approvals') }}" class="btn btn-primary float-start float-md-end py-2 mb-1"><i data-feather="arrow-left" class="feather-18 me-1 mb-1"></i> Back</a>
            </div>
        </div>
    </div>
    <div class="card-body px-0 py-0">
        <div class="table-responsive shadow-sm">
            <table class="table mb-0">
                <thead class="table-secondary">
                    <td class="py-3 border-bottom-0"><strong>ACCOUNT #</strong></td>
                    <td class="py-3 border-bottom-0"><strong>CLIENT NAME</strong></td>
                    <td class="py-3 border-bottom-0"><strong>REQUEST TYPE</strong></td>
                    <td class="py-3 border-bottom-0"><strong>DATE OF REQUEST</strong></td>
                    <td class="py-3 border-bottom-0"><strong>ACTION</strong></td>
                </thead>
                <tbody>
                    @foreach($services as $service)
                    <tr>
                        <td>{{$service->customer->account_number}}</td>
                        <td>{{$service->customer->fullname()}}</td>
                        <td>{{$service->prettyType()}}</td>
                        <td>{{$service->created_at}}</td>
                        <td>
                            <a href="{{route('admin.waterworks.pending-for-completion.mark',$service)}}" class="text-success"><i data-feather="check" class="feather-18 me-1"></i> Mark as done</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<p class="text-center mt-5">
    <i data-feather="alert-circle"></i> No services that are pending for completion
</p>
<div class="d-flex justify-content-center mt-5">
    <a href="{{ route('admin.waterworks-request-approvals') }}" class="btn btn-primary text-center py-2"><i data-feather="arrow-left" class="me-1 feather-18"></i> Return Back</a>
</div>
@endif

@endsection
