@extends('layout.main')
@section('title', 'Create New User Account')

@section('content')

<div class="row mt-3 justify-content-center">
    
    <div class="col-12 col-md-8 col-lg-5 col-xl-4">
        <h3 class='text-center mt-3'>New User Account</h3>
        <form action="{{route('admin.users.store')}}" class="mt-5" method="post">
            @csrf
            <div class="mb-2">
                <span class="form-label">Full Name</span>
                <input type="text" class="form-control mt-0 @error('name') is-invalid @enderror" placeholder="John Doe"  name='name' value="{{old('name')}}">
                @error('name')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>  
     
            <div class="mb-2">
                <span class="form-label">Username</span>
                <input type="text" class="form-control @error('username') is-invalid @enderror" name='username' value="{{old('username')}}">
                @error('username')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
      
            <div class="mb-2">
                <span class="form-label">Password <small class='text-muted'>(Must be at least 8 characters)</small></span>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name='password'>
                @error('password')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <span class="form-label">Confirm Password</span>
                <input type="password" class="form-control" name='password_confirmation'>
            </div>

            <select class="form-select" name="role" required>
                <option selected>--Select one--</option>
                @foreach($roles as $key=>$value)
                <option value="{{$key}}">{{$value}}</option>
                @endforeach
             
              </select>

            <center>
                <button type="submit" class="btn btn-primary mt-4"><i data-feather="edit-3" class="feather-18 me-1 mb-1"></i> Register</button>
            </center>
        </form>
    </div>
</div>


@endsection