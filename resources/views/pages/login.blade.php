@extends('layout.main')

@section('title','Login')

@section('content')

<div class="container login">
    <h1 class="text-center mt-5">Macrohon Water System</h1>
    <div class="row justify-content-center mb-5 mt-3">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5 px-xl-4">
           
            <h1 class="text-center mb-4 mt-4 h3" style="font-weight: normal;"><i data-feather="lock" class="mb-1"></i> Sign in</h1>
            @if(old('username'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Invalid credentials!</strong> Please try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            @if(session('updated-password'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                <strong>Great!</strong> {{session('message')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <div class="card shadow rounded-3 mb-1">
                <div class="card-header p-4">
                <span class="text-muted"> Note: Please don't share your account to anyone.</span>
                </div>
                <div class="card-body p-4">
                    <form action="{{route('login')}}" method="post">
                        @csrf
                        <label for="" class="form-label mb-0">Username</label>
                        <input type="text" value="{{old('username')}}" id="username" name="username" class="form-control mb-2 rounded-sm py-2" placeholder="Enter username">
                    
                        <label for="" class="form-label mb-0">Password</label>
                        <input type="password" name="password" class="form-control rounded-sm py-2" placeholder="Enter password">
                        <center>
                            <button class="btn btn-primary py-2 px-3 mt-4" type="submit"><i data-feather="key" width="20"></i>&nbsp; Log In</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection