<div class="row">
    <div class="col-md-12 mt-2">
        <h1 class="text-secondary text-center mt-3"><strong>Macrohon Municipal Waterworks System</strong></h1>
    </div>
</div>
<h4 class="text-secondary mt-5">WELCOME : {{ strtoupper(Auth::user()->name) }}</h4>
<div class="row">
    <div class="col-md-6">
        <h3 class="mt-2 h5 text-secondary ps-0"><i data-feather="edit-3" class="ps-0"></i>&nbsp; Logged in as: &nbsp;<span class="text-primary">{{ Auth::user()->user_role() }} - {{ Auth::user()->username }}</span></h3>
    </div>
    <div class="col-md-6">
        <div class="dropdown float-md-end">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <i data-feather="settings" class="me-1 feather-18"></i> Settings
            </button>
            <ul class="dropdown-menu px-1 pb-0" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item mt-1" href="{{route('users.update-password.edit')}}">Change Password</a></li>
                <li><a class="dropdown-item pb-0 mb-0" href="#">
                    <form action="{{route('logout')}}" method="post" class="mt-0 pb-1 px-0 pt-0 w-100">
                        @csrf
                        <button type="submit" class="border-0 bg-transparent mt-0">Sign-out</button>
                    </form></a>
                </li>
            </ul>
        </div>
    </div>
</div>
