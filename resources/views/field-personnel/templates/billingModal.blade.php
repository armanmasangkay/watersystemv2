<div class="modal modal-fluid fade" id="ledgerSetupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('admin.save-billing') }}" method="post" id="billing-form">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title text-muted" id="exampleModalLabel"><i data-feather="file"></i><strong>&nbsp; New Billing Setup</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <h6 class="text-danger">Note: Fields with (*) is required.</h6>
                    <h5 class="text-muted mt-4">Meter Reading</h5>
                    <div class="row mt-3 mb-2">
                        <div class="col-lg-4 col-md-6 mb-sm-2 pe-md-1 pe-sm-1">
                            <label class='text-muted'>Meter Reading <span class="text-danger">*</span></label>
                            <input class="form-control" id="meter-read" name="meter_read" type="number" placeholder="0" min=0 readOnly value="">
                        </div>
                        <div class="col-lg-4 col-md-6 mb-sm-2 ps-md-0 pe-md-0 ps-sm-1">
                            <label class='text-muted mt-1'>Reading Date <span class="text-danger">*</span></label>
                            <input class="form-control" id="read-date" name="read_date" type="text" placeholder="mm/dd/yyyy" min=0 readonly value="{{ \Carbon\Carbon::parse(date('Y-m-d'))->format('F d, Y') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i data-feather="x"></i> Close</button>
                    <button type="submit" class="btn btn-primary" id="save-billing" disabled><i data-feather="check"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>