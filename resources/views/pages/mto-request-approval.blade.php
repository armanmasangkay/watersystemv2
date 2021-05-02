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
        <h3 class="h4 mb-3 mt-2 text-left"><i data-feather="align-left" class="feather-16 mx-1"></i> Lists of Request for MTO Approvals</h3>
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
                        <td class="border-bottom pt-3 pb-3"><i data-feather="calendar" class="mx-1 text-primary" width="18"></i> INTL. BLDG/AREA INSP. DATE</td>
                        <td class="border-bottom pt-3 pb-3"><i data-feather="calendar" class="mx-1 text-primary" width="18"></i> INTL. WATER WORKS INSP. DATE</td>
                        <td class="border-bottom pt-3 pb-3"><i data-feather="activity" class="mx-1 text-primary" width="20"></i> ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="pt-2 pb-2">020-2021-001</td>
                        <td class="pt-2 pb-2">Nobegin Masub</td>
                        <td class="pt-2 pb-2">New Connection</td>
                        <td class="pt-2 pb-2">04-28-2021</td>
                        <td class="pt-2 pb-2">04-28-2021</td>
                        <td class="pt-2 pb-2">04-28-2021</td>
                        <td class="">
                            <a href="" class="text-primary mb-1 mx-2">
                            <i data-feather="check" width="20"></i></a>
                            <a href="" class="text-danger mb-1 mx-2">
                            <i data-feather="x" width="20"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="pt-2 pb-2">020-2021-002</td>
                        <td class="pt-2 pb-2">Benj Areten Masub</td>
                        <td class="pt-2 pb-2">New Connection</td>
                        <td class="pt-2 pb-2">04-30-2021</td>
                        <td class="pt-2 pb-2">04-30-2021</td>
                        <td class="pt-2 pb-2">04-30-2021</td>
                        <td class="pt-2 pb-2">
                            <a href="" class="text-primary mb-1 mx-2">
                            <i data-feather="check" width="20"></i></a>
                            <a href="" class="text-danger mb-1 mx-2">
                            <i data-feather="x" width="20"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="pt-2 pb-2 px-2 bg-light">
                <button class="btn btn-primary rounded-sm">
                    <i data-feather="chevrons-left" width="20"></i> Prev
                </button>
                <button class="btn btn-default rounded-sm">1</button>
                <button class="btn btn-default rounded-sm">2</button>
                <button class="btn btn-default rounded-sm">3</button>
                <button class="btn btn-default rounded-sm">4</button>
                <button class="btn btn-default rounded-sm">5</button>
                <button class="btn btn-primary rounded-sm"> Next
                    <i data-feather="chevrons-right" width="20"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection