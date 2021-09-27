@extends('layout.approval')

@section('title', 'Municipal Engineer')


@section('content')

<div class="row mb-0">
    @include('templates.user')
    <div class="col-md-8 pt-2">
        <h3 class="h4 mb-3 mt-2 text-left">PENDING FOR APPROVAL</h3>
    </div>
    <div class="col-md-4"></div>
</div>

<div class="card">
    <div class="card-header px-2 bg-light">
        <div class="row">
            <div class="col-md-6 py-0">
                @include('templates.form-search-account')
            </div>
            @if(isset(request()->keyword))
                <x-button :url="$index_route"/>
            @endif
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive p-0">
            <table class="table mb-0" style="min-width: 1300px !important">
                <thead class="bg-light">
                    <tr>
                        <td class="border-bottom pt-3 pb-3"><i data-feather="bar-chart-2" class="mx-1 text-primary" width="18"></i> ACCOUNT NO</td>
                        <td class="border-bottom pt-3 pb-3"><i data-feather="user" class="mx-1 text-primary" width="18"></i> CLIENT NAME</td>
                        <td class="border-bottom pt-3 pb-3"><i data-feather="activity" class="mx-1 text-primary" width="18"></i> REQ. TYPE</td>
                        <td class="border-bottom pt-3 pb-3 text-secondary"><strong><i data-feather="calendar" class="mx-1 text-primary" width="18"></i> DATE OF REQUEST</strong></td>
                        <td class="border-bottom pt-3 pb-3 text-secondary"><strong><i data-feather="activity" class="mx-1 text-primary" width="20"></i> ACTIONS</strong></td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                    <tr>
                        <td class="pt-2 pb-2">{{$service->customer->account_number}}</td>
                        <td class="pt-2 pb-2">{{$service->customer->fullname()}}</td>
                        <td class="pt-2 pb-2">{{$service->prettyServiceType()}}</td>
                        <td class="pt-2 pb-2">{{$service->prettyRequestDate()}}</td>
                        <td class="d-flex justify-content-start py-0">
                            <form action="{{ route('admin.municipal-engineer.approve') }}" method="post" class="mb-0 mx-0 d-flex py-2">
                                @csrf
                                <input type="hidden" name="id" value="{{ $service->id }}">
                                <button type="submit" class="border-0 bg-white text-primary"><i data-feather="check" width="20"></i> Approve</button>
                            </form>
                            @if($service->isDeniable())
                            <form action="{{route('admin.municipal-engineer.deny', ['id' => $service->id])}}" method="post" class="mb-1 mx-0 py-2">
                                @csrf
                                <button type="submit" class="border-0 bg-white text-danger"><i data-feather="x" width="20"></i> Deny</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <p class="text-center text-muted my-4">No pending service</p>
                    @endforelse

                </tbody>
            </table>

            {{$services->links()}}

        </div>
    </div>
</div>

@endsection
