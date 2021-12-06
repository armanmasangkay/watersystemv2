@extends('layout.main')

@section('title','Login')

@section('content')
<div class="mt-4 text-center">
    <h1 class="display-3">Good day!</h1>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-5 col-xl-4">
        <div class="card text-center mt-4 shadow-sm">
            <h5 class="text-muted mt-4">Sign in</h5>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Account #" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
                <small>
                    No account yet? <a href="{{route('consumer.signup.index')}}">Sign up</a>
                </small>
            </div>
            <div class="card-footer text-muted">
            <small>Don't share your password to anyone</small>
            </div>
        </div>
    </div>
</div>

@endsection