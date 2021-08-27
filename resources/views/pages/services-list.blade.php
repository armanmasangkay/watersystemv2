@extends('layout.main')

@section('title', 'Service Lists')

@section('content')

<div class="row">
    <div class="col-md-8 offset-md-2">
        <h3 class="mt-4">List of Services</h3>
        <div class="card">
            <div class="table-responsive mb-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <td scope="col" class="border-bottom-0 py-3"><strong>FULL NAME</strong></td>
                            <td scope="col" class="border-bottom-0 py-3"><strong>TYPE OF SERVICE</strong></td>
                            <td scope="col" class="border-bottom-0 py-3"><strong>REMARKS</strong></td>
                            <td scope="col" class="border-bottom-0 py-3"><strong>LANDMARKS</strong></td>
                            <td scope="col" class="border-bottom-0 py-3"><strong>CONTACT NUMBER</strong></td>
                            <td scope="col" class="border-bottom-0 py-3"><strong>STATUS</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($services as $service)
                            <tr>
                                <td scope="row" class="border-bottom-0 border-top">{{$service->customer->fullname()}}</td>
                                <td scope="row" class="border-bottom-0 border-top">{{ App\Classes\Facades\StringHelper::toReadableService($service->type_of_service)}}</td>
                                <td scope="row" class="border-bottom-0 border-top">{{$service->remarks}}</td>
                                <td scope="row" class="border-bottom-0 border-top">{{$service->landmarks}}</td>
                                <td scope="row" class="border-bottom-0 border-top">{{$service->contact_number}}</td>
                                <td scope="row" class="border-bottom-0 border-top">{{App\Classes\Facades\StringHelper::toReadableStatus($service->status)}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center border-top border-bottom-0">No records yet!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{$services->render()}}
    </div>
</div>
@endsection

