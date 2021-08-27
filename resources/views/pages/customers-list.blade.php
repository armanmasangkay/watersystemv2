@extends('layout.main')

@section('title', 'Customers')

@section('content')

<div class="container mt-5">
    <h5 class="text-secondary h4"><i data-feather="align-right" class="mb-1 feather-30 me-1"></i> Lists of Consumers</h5>
    <div class="card border">
        <div class="card-header border-0 px-2 pb-0 pt-2 bg-white">
            <div class="row">
                <div class="col-lg-5 col-md-7 col-sm-8 pe-md-0 pe-md-5">
                    <form action="{{route('admin.searched-customers.index')}}" class="mb-0" action="get">
                        <div class="input-group mb-2">
                            <input type="text" name='keyword' value="{{$keyword??''}}" class="form-control @error('keyword')is-invalid @enderror" placeholder="Enter name or account #" aria-describedby="button-addon2">
                            <button class="btn btn-primary" type="submit" id="button-addon2"><i data-feather="search" class="feather-20 me-1"></i> Search</button>
                            @error('keyword')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                              {{$message}}
                            </div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="col-lg-7 col-md-5 col-sm-4" align="right">
                    @if(isset($keyword))
                    <small>
                        <a class="btn btn-primary mb-3 pb-2 pt-2" href="{{route('admin.customers')}}"><i data-feather="align-center" class="feather-20 mx-1 pb-1 pt-1"></i> Show all</a>
                    </small>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive border-top">
                <table class="table table-hover {{ ($customers->count() < 10) ? 'mb-0' : '' }}">
                    <thead class="table-white">
                        <tr>
                            <th class="text-secondary py-3 border-bottom-0">ACCOUNT #</th>
                            <th class="text-secondary py-3 border-bottom-0">FULL NAME</th>
                            <th class="text-secondary py-3 border-bottom-0">CIVIL STATUS</th>
                            <th class="text-secondary py-3 border-bottom-0">CONTACT #</th>
                            <th class="text-secondary py-3 border-bottom-0">ADDRESS</th>
                            <th class="text-secondary py-3 border-bottom-0">CONNECTION TYPE</th>
                            <th class="text-secondary py-3 border-bottom-0">CONNECTION STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($customers->count()>0)

                        @foreach ($customers as $customer)
                        <tr style="cursor: pointer;" onclick='location.href=`{{ route("admin.search-transactions", ["account_number" => $customer->account_number]) }}`'>
                            <td class="text-primary border-top {{ ($customers->count() < 2) ? 'border-bottom-0' : '' }} "><strong>{{$customer->account_number}}</strong></td>
                            @if($customer->isOrgAccount())
                            <td class="text-secondary border-secondary {{ ($customers->count() < 2) ? 'border-bottom-0' : '' }} ">
                              ORG/COMPANY: <strong>{{$customer->org_name}}</strong><br>
                              <small class="text-muted">Registered by ({{$customer->fullname()}})</small>
                            </td>
                            @else
                            <td class="text-secondary border-top {{ ($customers->count() < 2) ? 'border-bottom-0' : '' }} ">{{$customer->firstname . ' ' .$customer->middlename. ' '.$customer->lastname}}</td>
                            @endif
                            
                            <td class="text-secondary border-top {{ ($customers->count() < 2) ? 'border-bottom-0' : '' }} ">{{Str::ucfirst($customer->civil_status)}}</td>
                            <td class="text-secondary border-top {{ ($customers->count() < 2) ? 'border-bottom-0' : '' }} ">{{$customer->contact_number}}</td>
                            <td class="text-secondary border-top {{ ($customers->count() < 2) ? 'border-bottom-0' : '' }} ">{{$customer->purok.', '.$customer->barangay}}</td>
                            <td class="text-secondary border-top {{ ($customers->count() < 2) ? 'border-bottom-0' : '' }} ">{{Str::ucfirst($customer->connection_type)}}</td>
                            <td class="text-secondary border-top {{ ($customers->count() < 2) ? 'border-bottom-0' : '' }} ">{{Str::ucfirst($customer->connection_status)}}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                          <td class="text-center text-secondary py-3 border-top {{ ($customers->count() < 1) ? 'border-bottom-0' : '' }}" colspan="7"><i data-feather="user-x" class="feather-20 me-1"></i> No records to display</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                
            </div>
            
        </div>
   
    </div>
    {{-- Export link --}}
    @if($customers->count()>0)
    <div class="pt-2">
        <a href="{{route('admin.customers.export',['keyword'=>isset($keyword)?$keyword:''])}}" class="btn btn-secondary py-2"><i data-feather="download" class="feather-20 me-1 pb-1"></i> Export Data</a>
    </div>
    @endif
</div>
@endsection
