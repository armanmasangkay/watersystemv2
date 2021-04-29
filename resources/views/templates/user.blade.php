<div class="d-flex justify-content-start">
    <h3 class="mt-5 h5"><i data-feather="edit-3"></i>&nbsp; Logged in as: &nbsp;<span class="text-primary">Administrator - Benj</span></h3>
    <form action="{{route('admin.logout')}}" method="post" class="mt-4 px-3 pt-3">
        @csrf
        <button type="submit" class="btn btn-default border-0 text-danger pt-2">
        <i data-feather="log-out" class="feather-16 mb-1"></i>&nbsp; Logout
        </button>
    </form>
</div>