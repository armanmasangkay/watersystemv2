@extends('layout.approval')

@section('title', 'New Connection')


@section('content')
<div class="row">
    <div class="col-md-12 mt-2">
        <h3><b>MWS - Macrohon Water System</b></h3>
    </div>
</div>
<div class="row mb-0">
    @include('templates.user')
    <div class="col-md-8 pt-2">
        <h3 class="h4 mb-3 mt-2 text-left"><i data-feather="align-left" class="feather-16 mx-1"></i> Lists of Request for Building/Area Inspections</h3>
    </div>
    <div class="col-md-4"></div>
</div>

<div class="card">
    <div class="card-header px-2 bg-light">
        @include('templates.form-search-account')
    </div>
    <div class="card-body p-0">
        <div class="table-responsive p-0">
            <table class="table mb-0" style="min-width: 1300px !important">
                <thead class="bg-light">
                    <tr>
                        <td class="border-bottom pt-3 pb-3"><i data-feather="bar-chart-2" class="mx-1 text-primary" width="18"></i> ACCOUNT NO</td>
                        <td class="border-bottom pt-3 pb-3"><i data-feather="user" class="mx-1 text-primary" width="18"></i> CLIENT NAME</td>
                        <td class="border-bottom pt-3 pb-3"><i data-feather="activity" class="mx-1 text-primary" width="18"></i> REQ. TYPE</td>
                        <td class="border-bottom pt-3 pb-3"><i data-feather="calendar" class="mx-1 text-primary" width="18"></i> DATE OF REQ.</td>
                        <td class="border-bottom pt-3 pb-3"><i data-feather="calendar" class="mx-1 text-primary" width="18"></i> INTL. BLDG/AREA INSP. SCHED.</td>
                        <td class="border-bottom pt-3 pb-3"><i data-feather="calendar" class="mx-1 text-primary" width="18"></i> INTL. WATER WORKS SCHED.</td>
                        <td class="border-bottom pt-3 pb-3"><i data-feather="activity" class="mx-1 text-primary" width="20"></i> ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td class="pt-2 pb-2">{{ $transaction->customer->account_number }}</td>
                            <td class="pt-2 pb-2">{{ $transaction->customer->fullname() }} </td>
                            <td class="pt-2 pb-2">{{ $transaction->type_of_service }}</td>
                            <td class="pt-2 pb-2">{{ $transaction->created_at->format('Y-m-d') }}</td>
                            <td class="pt-2 pb-2">{{ $transaction->building_inspection_schedule }}</td>
                            <td class="pt-2 pb-2">{{ $transaction->water_works_schedule }}</td>
                            <td class="d-flex justify-content-start">
                                <form action="{{ route('admin.bld-request-approvals-approve') }}" method="post" class="mb-1 mx-0 d-flex">
                                    @csrf
                                    <input type="date" name="building_inspection_schedule" class="form-control">
                                    <input type="hidden" name="id" value="{{ $transaction->id }}">
                                    <button type="submit" class="btn btn-xs btn-default text-primary"><i data-feather="check" width="20"></i></button>
                                </form>
                                {{-- <a href="" class="text-primary mb-1 mx-2">
                                <i data-feather="check" width="20"></i></a> --}}
                                <form action="{{route('admin.bld-request-approvals-reject', ['id' => $transaction->id])}}" method="post" class="mb-1 mx-0">
                                    @csrf
                                    <button type="submit" class="btn btn-xs btn-default text-danger"><i data-feather="x" width="20"></i></button>
                                </form>
                                {{-- <a href="" class="text-danger mb-1 mx-2">
                                <i data-feather="x" width="20"></i></a> --}}
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td class="pt-2 pb-2 text-center" colspan="8">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pt-2 pb-2 px-2 bg-light">
                <div class="pt-2 px-2 pb-2">
                    {{ $transactions->render() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
