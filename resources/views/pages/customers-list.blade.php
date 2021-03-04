@extends('layout.main')

@section('title', 'Customers')


@section('content')


<div class="card mt-4 shadow">
    <div class="card-header">
        <h4 class='text-center'><i class="fas fa-users"></i> Customers</h4>
    </div>
    <div class="card-body">

        @if($customers->count()>0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                  <tr>
                    <th scope="col">Acc #</th>
                    <th scope="col">Fullname</th>
                    <th scope="col">Civil Status</th>
                    <th scope="col">Contact #</th>
                    <th scope="col">Address</th>
                    <th scope="col">Connection Type</th>
                    <th scope="col">Connection Status</th>
                  </tr>
                </thead>
                <tbody>
            
                    @foreach ($customers as $customer)
                    <tr>
                        <th>{{$customer->account_number}}</th>
                        <td>{{$customer->firstname . ' ' .$customer->middlename. ' '.$customer->lastname}}</td>
                        <td>{{Str::ucfirst($customer->civil_status)}}</td>
                        <td>{{$customer->contact_number}}</td>
                        <td>{{$customer->purok.', '.$customer->barangay}}</td>
                        <td>{{Str::ucfirst($customer->connection_type)}}</td>
                        <td>{{Str::ucfirst($customer->connection_status)}}</td>
                    </tr>
                    @endforeach
               
                </tbody>
              </table>
            </div> 

            {{$customers->links()}}
          @else
          <div class="text-muted text-center">
              <h3><i class="fas fa-user-times"></i></h3>
              <p>There are no currently registered customer.</p>
          </div>
            

          @endif
    </div>
</div>

 



@endsection