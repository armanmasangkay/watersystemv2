@extends('layout.main')

@section('title', 'Admin Lists')

@section('content')

<div class="row">
    <div class="col-md-8 offset-md-2">
        @if(session('created'))
        <div class="alert alert-success alert-dismissible fade show mt-4 mb-2" role="alert">
            <strong>Great!</strong> {{session('message')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <h3 class="mt-4">List of System Admin</h3>
        <a class="btn btn-primary mb-3 pb-2 pt-2 mt-2" href="{{route('admin.admin-create')}}"><i data-feather="user-plus" class="feather-20 mx-1 pb-1 pt-1"></i> Register new</a>
        <div class="card">
            <div class="table-responsive mb-0">
                <table class="table mb-0">
                    <thead>       
                        <tr>
                            <td scope="col" class="border-bottom-0 py-3"><strong>FULL NAME</strong></td>
                            <td scope="col" class="border-bottom-0 py-3"><strong>USERNAME</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $admin)
                        <tr>
                            <td scope="row" class="border-bottom-0 border-top">{{$admin->name}}</td>
                            <td class="border-bottom-0 border-top">{{$admin->username}}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center border-top border-bottom-0">No records yet!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

