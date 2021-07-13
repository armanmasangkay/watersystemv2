@extends('layout.main')
@section('title', 'Cashiers')

@section('content')
@if(session('created'))
<div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
    <strong>Great!</strong> {{session('message')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<h3 class="mt-4">List of Cashiers</h3>


<a class="btn btn-primary mb-3 pb-2 pt-2" href="{{route('admin.cashiers.create')}}"><i data-feather="user-plus" class="feather-20 mx-1 pb-1 pt-1"></i> Register new</a>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>       
          <tr>
            <th scope="col">Name</th>
            <th scope="col">username</th>
          </tr>
        </thead>
        <tbody>
            @foreach($cashiers as $cashier)
    
            <tr>
                <th scope="row">{{$cashier->name}}</th>
                <td>{{$cashier->username}}</td>
              </tr>
            @endforeach
        
        </tbody>
      </table>

</div>

@endsection