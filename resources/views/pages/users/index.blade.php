@extends('layout.main')

@section('title', 'Cashiers')

@section('content')

<div class="row">
  <div class="col-md-8 col-lg-12">
    @if(session('created') || session('resetted-password'))
    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
        <strong>Great!</strong> {{session('message')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <h3 class="mt-4">List of User Accounts</h3>
<a class="btn btn-primary mb-3 pb-2 pt-2 mt-2" href="{{route('admin.users.create')}}"><i data-feather="user-plus" class="feather-20 mx-1 pb-1 pt-1"></i> Register new</a>
    <div class="card">
      <div class="table-responsive mb-0">
        <table class="table mb-0">
            <thead>       
              <tr>
                <td scope="col" class="border-bottom-0 py-3"><strong>FULL NAME</strong></td>
                <td scope="col" class="border-bottom-0 py-3"><strong>USERNAME</strong></td>
                <td scope="col" class="border-bottom-0 py-3"><strong>ACTIONS</strong></td>
              </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                  <td scope="row" class="border-bottom-0 border-top">{{$user->name}}</td>
                  <td class="border-bottom-0 border-top">{{$user->username}}</td>
                  <td class="border-bottom-0 border-top">
                    
                    <a href="{{route('admin.users.edit',$user)}}">Edit</a>
                    <span> | </span>
                    <form action="{{route('admin.users.destroy',$user)}}" method="post" style="display:inline">
                      @csrf
                      @method("DELETE")
                      <button type="submit" class="btn btn-link" onclick="return confirm('Are you sure you want to delete this user? This cannot be reverted back.')">Delete</button>
                    </form>
                    <span> | </span>
                    <form action="{{route('admin.user-passwords.update',$user)}}" method="post" style="display:inline">
                      @csrf
                      @method("PUT")
                      <button type="submit" class="btn btn-link">Reset Password</a>
                    </form>
              
                  </td>
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
    {{$users->links()}}
  </div>
</div>
@endsection