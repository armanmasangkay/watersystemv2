@extends('layout.main')
@section('title', 'Change Account Password')

@section('content')

<div class="row mt-3 justify-content-center">
    <div class="col-12 col-md-8 col-lg-5 col-xl-4">
        <div class="card mt-3">
            <div class="card-header py-3">
                <h3 class='text-center'>Change Account Password</h3>
            </div>
            <div class="card-body px-4">
                <form action="{{route('users.update-password.store')}}" class="mt-3" method="post">
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

                <div class="mb-3">
                    <span class="form-label">Confirm Password</span>
                    <input type="password" class="form-control" name='password_confirmation' required>
                </div>

                <center>
                    <a href="{{ URL::previous()}}"  class="btn btn-secondary mt-4 p-2"> <i data-feather="corner-down-left" class="feather-18 me-1 mb-1"></i> Back</a>
                    <button type="submit" class="btn btn-primary mt-4"><i data-feather="edit-3" class="feather-18 me-1 mb-1"></i> Update</button>
                </center>
            </form>
    </div>
</div>


@endsection
