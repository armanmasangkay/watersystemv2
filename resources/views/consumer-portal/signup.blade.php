@extends('layout.main')

@section('title','Login')

@section('content')

<div class="text-center mt-4">
    <h1>Macrohon Water's</h1>
    <h1 class="display-3">Consumer Portal</h1>
    <h4 class="my-4"><i class="fas fa-user-plus"></i> Sign up</h4>
</div>

@if(session('created'))
<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Great!!</strong> {{session('message')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif


<div class="row justify-content-center">
    <div class="col-12 col-xl-8">
        <div class="card p-md-2 shadow-sm">
            <div class="card-body">
                <p class="mb-3">
                    <small class="text-muted">Fields with <span class="text-danger">*</span> are required</small>
                </p>
                <form method="POST" action="{{route('consumer.signup.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label"><span class="text-danger">*</span> Account #</label>
                                <input type="text" class="form-control @error('account_number') is-invalid @enderror"  name="account_number" value="{{old('account_number')}}">
                                @error('account_number')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><span class="text-danger">*</span> Email Address</label>
                                <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{old('email')}}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><span class="text-danger">*</span> Mobile number</label>
                                <input type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" value="{{old('mobile_number')}}">
                                @error('mobile_number')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><span class="text-danger">*</span> Password</label>
                                <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><span class="text-danger">*</span> Confirm Password</label>
                                <input type="password" class="form-control  @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                                @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
        
                   <div class="row">
                       <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="formFile" class="form-label"><span class="text-danger">*</span> Valid ID</label>
                                <input class="form-control @error('valid_id') is-invalid @enderror" type="file" style="height:auto !important" name="valid_id">
                                @error('valid_id')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                       </div>
                       <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="formFile" class="form-label"><span class="text-danger">*</span> Latest Bill Photo</label>
                                <input class="form-control @error('latest_bill') is-invalid @enderror" type="file" style="height:auto !important" name="latest_bill">
                                @error('latest_bill')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                       </div>
                   </div>

              
                  <div class="row">
                    <div class="col-12 col-md-6 d-flex flex-md-column justify-content-center">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" style="height:1em !important" name="is_in_behalf" {{old('is_in_behalf')?'checked':''}}>
                            <label class="form-check-label">
                            Check the box if you are registering in behalf of an organization/individual.
                            </label>
                        </div>
                    </div>
                      <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Full name</label>
                            <input type="text" class="form-control @error('other_party_name') is-invalid @enderror" name="other_party_name">
                            <div class="form-text">Required only if you are registerting in behalf of an organization/invidual</div>
                            @error('other_party_name')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                      </div>
                  </div>

                  <div class="d-grid gap-2 col-md-5 col-lg-4 mx-auto">
                    <button class="btn btn-primary" type="submit">Submit</button>
                    </div>

                  <div class="text-center mt-2">
                    <small>Already have an account? <a href="{{route('consumer.signin.index')}}">Sign in</a></small>
                  </div>
                </form> 
            </div>
        </div>
    </div>
</div>




@endsection