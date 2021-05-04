
<form action="{{ route($route) }}" method="get" class="mb-0 form-inline">
    <!-- <div class="col-12 col-md-6 col-lg-5 col-xl-4 mx-0 p-0 mt-0 mb-0"> -->
        <input type="text" name="account_number" class="w-25 rounded bg-white border pt-2 pb-2 px-2 
        @error('account_number') is-invalid @enderror" id="" value="{{old('account_number',$customer->account_number)}}" 
        placeholder="Account number" required>
      
    <!-- </div> -->
    <button href="" class="btn btn-primary mb-1">
    <i data-feather="search" width="20"></i>
    Search</button>

    @error('account_number')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
</form>