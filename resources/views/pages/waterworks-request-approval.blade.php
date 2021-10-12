@extends('layout.approval')

@section('title', 'Waterworks Approval Page')


@section('content')
<div class="row mb-0">
    @include('templates.user')
    <div class="col-md-8 pt-2 mt-4">
        <h3 class="h4 mb-3 mt-2 text-left text-secondary"><i data-feather="align-left" class="feather-16 mx-1"></i> Lists of Request for Water Works Inspections</h3>
    </div>
    <div class="col-md-4 pt-2 mt-4">
        <div class="float-start float-md-end ms-3">
            <a href="{{route('admin.waterworks.pending-for-completion')}}" class="btn btn-primary border" style="height: 40px;">
                Pending for Completion
            </a>
        </div>
        <div class="float-start float-md-end me-2">
            <div class="btn bg-light position-relative">
                <i data-feather="activity" class="me-1 feather-18"></i> Pending Services
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $services->count() }}
                    <span class="visually-hidden">unread messages</span>
                </span>
            </div>
        </div>
        
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header px-2 py-0 bg-light">
        <div class="row">
            <div class="col-md-6 py-0">
                @include('templates.form-search-account')
            </div>
            <div class="col-md-6 py-2">
                @if(isset(request()->keyword))
                    <x-button :url="$index_route" btnText="Show All"/>
                @else
                    <x-button :url="$index_route" btnText="Refresh"/>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive p-0">
            <table class="table mb-0" style="min-width: 1300px !important">
                <thead class="bg-light">
                    <tr>
                        <td class="border-bottom pt-3 pb-3 "><strong><i data-feather="bar-chart-2" class="mx-1 text-primary" width="18"></i> ACCOUNT NO</td>
                        <td class="border-bottom pt-3 pb-3 "><strong><i data-feather="user" class="mx-1 text-primary" width="18"></i> CLIENT NAME</td>
                        <td class="border-bottom pt-3 pb-3 "><strong><i data-feather="activity" class="mx-1 text-primary" width="18"></i> REQUEST TYPE</td>
                        <td class="border-bottom pt-3 pb-3 "><strong><i data-feather="calendar" class="mx-1 text-primary" width="18"></i> DATE OF REQUEST</td>
                        <td class="border-bottom pt-3 pb-3 "><strong><i data-feather="activity" class="mx-1 text-primary" width="20"></i> ACTIONS</td>
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
                            <td class="d-flex justify-content-start py-0">
                                <form action="{{ route('admin.waterworks-request-approvals-approve') }}" method="post" class="mb-0 mx-0 d-flex py-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $service->id }}">
                                    <button type="submit" class="border-0 bg-white text-primary"><i data-feather="check" width="20"></i> Approve</button>
                                </form>
                                @if($service->isDeniable())
                                <form action="{{route('admin.waterworks-request-approvals-reject', ['id' => $service->id])}}" method="post" class="mb-1 mx-0 py-2">
                                    @csrf
                                    <button type="submit" class="border-0 bg-white text-danger"><i data-feather="x" width="20"></i> Deny</button>
                                </form>
                                @endif
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

@endsection
