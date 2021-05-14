<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h4 class="modal-title" id="exampleModalLabel">Water Rate</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-4 px-5">
                <form action="{{ route('admin.water-rate-update') }}" method="post">
                    @csrf
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control">
                        <option value="1">Residential</option>
                        <option value="2">Institutional</option>
                        <option value="3">Commercial</option>
                    </select>
                    <label for="min_rate">Minimum Rate</label>
                    <input type="number" name="min_rate" class="form-control" placeholder="0.00">
                    <label for="excess_rate">Excess Rate</label>
                    <input type="number" name="excess_rate" id="excess_rate" class="form-control" placeholder="0.00">
                    <button class="btn btn-primary btn-md mt-3"><i data-feather="save" width="20" class="pb-1"></i> Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
