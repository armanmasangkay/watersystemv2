@extends('layout.main')

@section('title','Login')

@section('content')

<div class="text-center mt-4">
    <h1>Macrohon Water's</h1>
    <h1 class="display-3">Consumer Portal</h1>
    <h4 class="my-4"><i class="fas fa-user-plus"></i> Sign up</h4>
</div>
<div class="row justify-content-center">
    <div class="col-12 col-xl-8">
        <div class="card p-md-2 shadow-sm">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Account #</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Mobile number</label>
                                <input type="email" class="form-control">
                            </div>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control">
                            </div>
                        </div>
                    </div>
        
                   <div class="row">
                       <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Valid ID</label>
                                <input class="form-control" type="file" id="formFile" style="height:auto !important">
                            </div>
                       </div>
                       <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Latest Bill Photo</label>
                                <input class="form-control" type="file" id="formFile" style="height:auto !important">
                            </div>
                       </div>
                   </div>

              
                  <div class="row">
                    <div class="col-12 col-md-6 d-flex flex-md-column justify-content-center">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" style="height:1em !important">
                            <label class="form-check-label">
                            Check the box if you are registering in behalf of an organization/individual.
                            </label>
                        </div>
                    </div>
                      <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Full name</label>
                            <input type="text" class="form-control">
                            <div class="form-text">Required only if you are registerting in behalf of an organization/invidual</div>
                        </div>
                      </div>
                  </div>

                  <div class="d-grid gap-2 col-md-5 col-lg-4 mx-auto">
                    <button class="btn btn-primary" type="button">Submit</button>
                    </div>

                  <div class="text-center mt-2">
                    <small>Already have an account? <a href="{{route('consumer.login.index')}}">Sign in</a></small>
                  </div>
                </form> 
            </div>
        </div>
    </div>
</div>




@endsection