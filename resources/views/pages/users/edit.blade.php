@extends('layout.main')
@section('title', 'Create New User Account')

@section('content')

<div class="row mt-3 justify-content-center">
 

    <div class="col-12 col-md-8 col-lg-5 col-xl-4">
        <h3 class='text-center mt-3'>Updating ({{$user->name}}) Account</h3>

        @if(session('updated'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            <strong>Great!</strong> {{session('message')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <form action="{{route('admin.users.update',$user)}}" class="mt-5" method="post">
            @csrf
            @method("PUT")
            <div class="mb-2">
                <span class="form-label">Username</span>
                <input type="text" class="form-control-plaintext @error('username') is-invalid @enderror" name='username' value="{{$user->username}}" readonly>
               
                @error('username')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="mb-2">
                <span class="form-label">Full Name</span>
                <input type="text" class="form-control mt-0 @error('name') is-invalid @enderror" placeholder="John Doe"  name='name' value="{{$user->name}}" required>
                @error('name')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>  
        <span class="form-label">Role</span>
            <select class="form-select" name="role" required>
                <option value="" selected>--Select one--</option>
                @foreach($roles as $key=>$value)
                <option value="{{$key}}" {{($user->role==$key)? 'selected':''}}>{{$value}}</option>
                @endforeach
             
              </select>

            <center>
                <button type="submit" class="btn btn-primary mt-4"><i data-feather="edit-3" class="feather-18 me-1 mb-1"></i> Update</button>
            </center>
        </form>
    </div>
</div>


@endsection