@extends('layout.approval')

@section('title', 'Pending for Completion')


@section('content')
@include('templates.user')
<h3 class="mt-5 text-center"><i data-feather="check-square"></i> Pending for Completion</h3>
@if($services->count()>0)
<div class="table-responsive mt-4 shadow-sm">
    <table class="table table-bordered mb-0">
        <thead class="table-dark">
            <th>Account #</th>
            <th>Client Name</th>
            <th>Request Type</th>
            <th>Date of Request</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                <td>{{$service->customer->account_number}}</td>
                <td>{{$service->customer->fullname()}}</td>
                <td>{{$service->prettyType()}}</td>
                <td>{{$service->created_at}}</td>
                <td>
                    <a href="{{route('admin.waterworks.pending-for-completion.mark',$service)}}" class="btn btn-sm btn-success"><i data-feather="check"></i> Mark as done</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<p class="text-center mt-5">
    <i data-feather="alert-circle"></i> No services that are pending for completion
</p>
@endif

@endsection
