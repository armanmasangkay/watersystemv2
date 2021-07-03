@extends('layout.main')
@section('title', 'Cashiers')

@section('content')

<div class="row mt-3 justify-content-center">
    
    <div class="col-12 col-md-8 col-lg-5 col-xl-4">
        <h3 class='text-center'>New Cashier Account</h3>
        <hr>
    
        <form action="{{route('admin.cashiers.store')}}" method="post">
            @csrf
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="John Doe"  name='name' value="{{old('name')}}">
                @error('name')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>  
     
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" name='username' value="{{old('username')}}">
                @error('username')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
                 
            </div>
      
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name='password'>
                <small class='text-muted'>Must be at least 8 characters</small>
                @error('password')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name='password_confirmation'>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Register</button>
              </div>
            
        </form>

    </div>


</div>


@endsection