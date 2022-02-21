@extends('layout.main')

@section('title','Login')

@section('content')
<div class="mt-4 text-center">
    <h1 class="display-3">Good day!</h1>
</div>

@if(session('message'))
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5 col-xl-4">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{session('message')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif

<div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-5 col-xl-4">
        <div class="card text-center mt-2 shadow-sm">
            <h5 class="mt-4">Sign in</h5>
            <div class="card-body">
                <form action="{{route("consumer.signin")}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="account_number" class="form-control @error('account_number') is-invalid @enderror" placeholder="Account #" value="{{old('account_number')}}" required>
                        @error('account_number')
                        <div class="invalid-feedback text-start">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
                <small>
                    No account yet? <a href="{{route('consumer.signup.index')}}">Sign up</a>
                </small>
            </div>
            <div class="card-footer text-gray">
            <small>Don't share your password to anyone</small>
            </div>
        </div>
    </div>
</div>

@endsection