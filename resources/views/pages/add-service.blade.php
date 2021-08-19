@extends('layout.main')
@section('title', 'New Service')

@section('content')

<h4 class="mt-3 mb-4"><i data-feather="tool" class=""></i> Add New Service</h4>

<div class="row justify-content-center">
    <div class="col-12 col-md-4 ">

        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Account #" aria-label="Recipient's username" aria-describedby="button-addon2">
            <button class="btn btn-primary" type="button" id="button-addon2">Search</button>
        </div>
        <div class="mt-4">
            <small class="text-muted">New Account?</small>
            <a href="#" class="btn btn-outline-secondary btn-sm">Create New Connection</a>
        </div>
    </div>
    <div class="col-12 col-md-8">
        <form action="#" method="post">
            <h5>Applicant Information</h5>
            <hr>
            
            <div class="row">
                <div class="col">
                    <small class="text-muted">Name</small>
                    <h6>Arman M. Masangkay</h6>
                </div>
                <div class="col">
                    <small class="text-muted">Civil Status</small>
                    <h6>Married</h6>
                </div>
                <div class="col">
                    <small class="text-muted">Connection Type</small>
                    <h6>Residential</h6>
                </div>
                <div class="col">
                    <small class="text-muted">Contact #</small>
                    <h6>09757375747</h6>
                </div>

            </div>
            
            <small class="text-muted">Service Type</small>
            <select class="form-select form-select-sm" aria-label="Default select example">

                @foreach($services as $value=>$name)    
                <option value={{$value}}>{{$name}}</option>
                @endforeach
            </select>
    
            <small class="text-muted">Remarks</small>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            <div class="row mt-3">
                <div class="col-12 col-lg-6">
                    <small class="text-muted mt-4">Address</small>
                    <h6>Taliwa, Malitbog So. Leyte</h6>
                </div>
                <div class="col-12 col-lg-6">
                    <small class="text-muted">Landmark</small>
                    <input class="form-control" type="text"/>
                </div>
                
            </div>
           
            <div class="row">
                <div class="col-12 col-md-8 col-lg-5">
                    <small class="text-muted">Service Schedule</small>
                    <input class="form-control" type="date"/>
                </div>
            </div>
           

            <button type="submit" class="btn btn-primary mt-3">Submit</button>

        </form>
       
    </div>


</div>

@endsection