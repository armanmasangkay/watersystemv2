<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h4 class="modal-title" id="exampleModalLabel">Water Rate</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-4 px-5">
                <form action="{{ route('admin.water-rate-update') }}" id="water_rate_form" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select name="type" id="type"  class="form-control">
                            <option value=""></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="min_rate">Minimum Rate</label>
                        <div class="input-group">
                            <input type="number" id="min_rate" name="min_rate" class="form-control" placeholder="0.00" min="1" >
                            <div class="input-group-text">
                                <span>%</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="excess_rate">Excess Rate</label>
                        <div class="input-group">
                            <input type="number" name="excess_rate" id="excess_rate" class="form-control" placeholder="0.00" min="1" >
                            <div class="input-group-text">
                                <span>%</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit"  class="btn btn-primary btn-md mt-3"><i data-feather="save" width="20" class="pb-1"></i> Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{ asset('assets/js/water_rates.js') }}" defer></script>
