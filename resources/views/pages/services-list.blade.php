@extends('layout.main')

@section('title', 'Service Lists')

@section('content')

    <div class="col-md-8 offset-md-2">
        <div class="row">
            <div class="col-md-6 py-0">
                <h3 class="mt-4">List of Services</h3>
            </div>
            <div class="col-md-6 pt-md-3">
                <form action="{{ route('admin.services.filter')}}" class="row" method="get">
                    <select class="form-select col-md mx-3" name="filter" id="filter">
                        <option value="none">None</option>
                        @foreach ($status as $key => $value)
                            @if (request()->filter == $key)
                                <option value="{{$key}}" selected>{{ $value }}</option>
                            @else
                                <option value="{{$key}}">{{ $value }}</option>
                            @endif
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary col-md-3">Filter</button>
                </form>
            </div>
        </div>
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
                            <td scope="col" class="border-bottom-0 py-3"><strong>ACTION</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($services as $service)
                            <tr>
                                <td scope="row" class="border-bottom-0 border-top">{{$service->customer->fullname()}}</td>
                                <td scope="row" class="border-bottom-0 border-top">{{ $service->prettyType()}}</td>
                                <td scope="row" class="border-bottom-0 border-top">{{$service->remarks}}</td>
                                <td scope="row" class="border-bottom-0 border-top">{{$service->landmarks}}</td>
                                <td scope="row" class="border-bottom-0 border-top">{{$service->customer->contact_number}}</td>
                                <td scope="row" class="border-bottom-0 border-top">{{$service->prettyStatus()}}</td>
                                <td scope="row" class="border-bottom-0 border-top">
                                    <form action="{{route("admin.services.destroy",$service)}}" method="post">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn btn-link"
                                                onclick="return confirm('Are you sure you want to delete this? You cannot undo this action')">
                                                Delete
                                        </button>
                                    </form>

                                </td>
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

