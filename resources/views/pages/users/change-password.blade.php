@extends('layout.main')
@section('title', 'Change Account Password')

@section('content')

<div class="row mt-3 justify-content-center">
    

    <div class="col-12 col-md-8 col-lg-5 col-xl-4">
        @if(session('updated-password'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            <strong>Great!</strong> {{session('message')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <h3 class='text-center mt-3'>Change Account Password</h3>
        <form action="{{route('admin.users.update-password.store')}}" class="mt-5" method="post">
            @csrf
            @method("PUT")
            <div class="mb-2">
                <span class="form-label">Current Password</span>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name='current_password' required>
                @error('current_password')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="mb-2">
                <span class="form-label">New Password <small class='text-muted'>(Must be at least 8 characters)</small></span>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name='password' required>
                @error('password')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <span class="form-label">Confirm Password</span>
                <input type="password" class="form-control" name='password_confirmation' required>
            </div>

            <center>
                <button type="submit" class="btn btn-primary mt-4"><i data-feather="edit-3" class="feather-18 me-1 mb-1"></i> Update</button>
            </center>
        </form>
    </div>  
</div>


@endsection