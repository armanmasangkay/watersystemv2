@extends('layout.main')

@section('title','Login')

@section('content')
<div class="container">

    <h1 class="display-3 text-center mt-5">Macrohon Water System</h1>
    <hr>
    <div class="row justify-content-center mb-5">
        <div class="col-12 col-md-8 col-lg-6 col-xl-4">
           
            <h1 class="text-center mb-3 mt-3">Sign in</h1>
            @if(old('username'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Invalid credentials!</strong> Please try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
            <div class="card shadow-sm">
                <div class="card-header p-4">
                <span class="text-muted"> Note: Please don't share your account to anyone.</span>
                </div>
                <div class="card-body p-4">
                    <form action="{{route('login')}}" method="post">
                        @csrf
                        <label for="" class="form-label">Username</label>
                        <input type="text" value="{{old('username')}}" id="username" name="username" class="form-control mb-3">
                    
                        <label for="" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control">
                        <div class="d-grid gap-2 mt-4">
                            <button class="btn btn-primary py-2" type="submit">Log In</button>
                           
                        </div>
                    
                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection