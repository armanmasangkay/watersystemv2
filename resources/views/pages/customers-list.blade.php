@extends('layout.main')

@section('title', 'Customers')


@section('content')


<div class="container mt-5">
    <div class="card mt-4 shadow-sm">
      <!--  -->
      <div class="card-header">
          <h4 class='text-center'><i data-feather="users" class="feather-32"></i>&nbsp;&nbsp;Customers</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-8 col-lg-6 col-xl-4">

            <form action="{{route('admin.searched-customers.index')}}" action="get">
              <div class="input-group mb-3">
                <input type="text" name='keyword' value="{{$keyword??''}}" class="form-control @error('keyword')is-invalid @enderror" placeholder="Enter Name / Account #" aria-describedby="button-addon2">
                <button class="btn btn-outline-primary" type="submit" id="button-addon2">Search</button>
                @error('keyword')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>

          </form>
          </div>
        </div>
        @if(isset($keyword))
        <small>
          <a href="{{route('admin.customers')}}">Show all</a>
        </small>

        @endif
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
                      <tr style="cursor: pointer;" onclick="location.href='{{ route('admin.search-transactions', ['account_number' => $customer->account_number]) }}'">
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
                <p>Nothing to show</p>
            </div>

            @endif
      </div>
  </div>
</div>





@endsection
