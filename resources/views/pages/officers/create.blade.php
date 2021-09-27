@extends('layout.main')
@section('title', 'Create New Officer')

@section('content')

<div class="row mt-5 justify-content-center">
    <div class="col-12 col-md-8 col-lg-5 col-xl-4">
        <div class="card">
            <div class="card-header">
                <h4 class='text-center mt-2'><i data-feather="user-plus" class="mb-1"></i> New Officer</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.officers.store')}}" class="mt-2" method="post">
                    @csrf
                    <div class="mb-2">
                        <span class="form-label">Full Name</span>
                        <input type="text" class="form-control mt-0 @error('fullname') is-invalid @enderror" placeholder="John Doe"  name='fullname' value="{{old('fullname')}}">
                        @error('fullname')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <span class="form-label">Position</span>
                        <select class="form-select @error('position') is-invalid @enderror" name="position">
                            <option value="">--Select one--</option>
                            @foreach($positions as $key=>$value)
                                @if (old('position') == $key)
                                    <option value="{{$key}}" selected>{{$value}}</option>
                                @else
                                    <option value="{{$key}}">{{$value}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('position')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <center>
                        <button type="submit" class="btn btn-primary mt-4"><i data-feather="edit-3" class="feather-18 me-1 mb-1"></i>Add Officer</button>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
