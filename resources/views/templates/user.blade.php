<h4 class="text-secondary mt-5">WELCOME: {{ strtoupper(Auth::user()->name) }}</h4>
<div class="d-flex justify-content-start">
    <h3 class="mt-2 h5 text-secondary"><i data-feather="edit-3"></i>&nbsp; Logged in as: &nbsp;<span class="text-primary">{{ Auth::user()->user_role() }} - {{ Auth::user()->username }}</span></h3>
    <form action="{{route('admin.logout')}}" method="post" class="mt-0 px-3 pt-0">
        @csrf
        <button type="submit" class="btn btn-default border-0 text-danger mt-0">
        <i data-feather="log-out" class="feather-16 mb-1"></i>&nbsp; Logout
        </button>
    </form>
</div>