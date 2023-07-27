@extends('layout.main')

@section('title', 'Cashiers')

@section('content')

<div class="row mt-5">
  <div class="col-md-8 col-lg-12">
    @if(session('created') || session('deleted') || session('resetted-password'))
    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
        <strong>Great!</strong> {{session('message')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="row">
      <div class="col-md-6">
        <h3 class="mt-2"><i data-feather="align-left"></i> List of User Accounts</h3>
      </div>
      <div class="col-md-6">
        <a class="btn btn-primary mb-3 pb-2 pt-2 mt-2 float-end" href="{{route('admin.users.create')}}"><i data-feather="user-plus" class="feather-20 mx-1 pb-1 pt-1"></i> Register new</a>
      </div>
    </div>
    <div class="card">
      <div class="table-responsive mb-0">
        <table class="table mb-0">
            <thead>       
              <tr>
                <td scope="col" class="border-bottom-0 border-top-0 p-3"><strong>FULL NAME</strong></td>
                <td scope="col" class="border-bottom-0 border-top-0  p-3"><strong>USERNAME</strong></td>
                <td scope="col" class="border-bottom-0 border-top-0  p-3"><strong>ROLE</strong></td>
                <td scope="col" class="border-bottom-0 border-top-0  p-3"><strong>ACTIONS</strong></td>
              </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                  <td scope="row" class="p-3 border-bottom-0 border-top">{{$user->name}}</td>
                  <td class="p-3 border-bottom-0 border-top">{{$user->username}}</td>
                  <td class="p-3 border-bottom-0 border-top">{{$user->user_role()}}</td>
                  <td class="border-bottom-0 border-top py-2">
                    <div class="d-flex justify-content-start pe-0 my-1 me-0">
                      <a href="{{route('admin.users.edit',$user)}}" class="me-1 bg-warning py-1 px-2 rounded-1 text-white text-decoration-none">Edit</a>
                      <form action="{{route('admin.users.destroy',$user)}}" method="post" class="pt-0 mb-0">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="bg-danger py-1 px-2 rounded-1 text-white text-decoration-none border-0 mx-1" onclick="return confirm('Are you sure you want to delete this user? This cannot be reverted back.')">Delete</button>
                      </form>
                      <form action="{{route('admin.user-passwords.update',$user)}}" method="post" class="pt-0 mb-0">
                        @csrf
                        @method("PUT")
                        <button type="submit" class="btn-secondary border-0 py-1 px-2 rounded-1 text-white text-decoration-none mx-1">Reset Password</a>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center border-top border-bottom-0">No records yet!</td>
                </tr>
                @endforelse
            </tbody>
          </table>
        
      </div>
    
    </div>
    {{$users->links()}}
  </div>
</div>
@endsection