@extends('layout.main')

@section('title','Account Officer Dashboard')

@section('content')
<div class="my-2"><h2>Accounts</h2></div>
<hr>
<div>
    @if(session('message'))
    <div class="alert alert-success" role="alert">
        {{ session('message') }}
    </div>
  
    @endif

    @if($accounts->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Account Number#</th>
                <th>Email</th>
                <th>Mobile Number</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $account)
                <tr>
                    <td>{{ $account->account_number }}</td>
                    <td>{{ $account->email }}</td>
                    <td>{{ $account->mobile_number }}</td>
                    <td>{{ $account->status }}</td>
                    <td>
                        <form action="/account-officer/reset-password/consumer/{{$account->id}}" method="post">
                            @method('PUT')
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary btn-sm">Reset Password</button>
                        </form>
                    </td>
                </tr>
                
            @endforeach
        </tbody>
       
        
    </table>
    @else
         <p>No accounts to show!</p>
    @endif

</div>



@endsection