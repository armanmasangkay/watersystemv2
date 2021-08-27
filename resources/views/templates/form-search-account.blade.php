<form action="{{ route($route) }}" method="get" class="mt-2 mb-2 form-inline">
    <input type="text" name="account_number" class="{{ Request::is('admin/water-works/request-approvals*') || Request::is('admin/bldg-area/request-approvals*') ? 'w-50' : 'w-25' }} rounded bg-white border pt-2 pb-2 px-2 
    @error('account_number') is-invalid @enderror" id="" value="{{old('account_number',$customer->account_number??'')}}" 
    placeholder="Account number" required>

    <button href="" class="btn btn-primary mb-1">
    <i data-feather="search" width="20"></i>
    Search</button>

    @error('account_number')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
</form>