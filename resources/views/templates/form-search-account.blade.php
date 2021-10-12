<form action="{{ route($search_route) }}" method="get" class="mt-2 mb-2 form-inline">
    <input type="text" name="keyword" class="{{ Request::is('admin/water-works/request-approvals*') || Request::is('admin/bldg-area/request-approvals*') ? 'w-50' : 'w-25' }} rounded bg-white border pt-2 pb-2 px-2
    @error('keyword') is-invalid @enderror" id="" value="{{old('keyword',request()->keyword??'')}}"
    placeholder="Account number/ Name" required>

    <button href="" class="btn btn-primary mb-1">
    <i data-feather="search" width="20"></i>
    Search</button>

    @error('account_number')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
</form>


