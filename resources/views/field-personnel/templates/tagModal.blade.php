<div class="modal modal-fluid fade" id="tagSetupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="" method="post" id="billing-form">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title text-muted" id="exampleModalLabel"><i data-feather="tag"></i><strong>&nbsp; Tagging Services</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <p class="text-danger">Reminder: Fields with (*) is required.</p>
                    <h3 class="text-muted mt-4"><strong>Consumer Meter Tagging </strong></h3>
                    <div class="row mt-4 mb-2">
                        <div class="ms-4">
                            <p class="mb-0">Select reason(s) <span class="text-danger">*</span></p>
                            <div class="ms-4">
                                <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="checkbox" name="" id="" class="me-2 mt-1">Broken Meter</h6>
                                <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="checkbox" name="" id="" class="me-2 mt-1">Transfer Meter Location</h6>
                                <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="checkbox" name="" id="" class="me-2 mt-1">Transfer of Ownership</h6>
                                <!-- <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="checkbox" name="" id="" class="me-2 mt-1"></h6>
                                <h6 class="d-flex justify-content-start align-items-center py-0 my-0"><input type="checkbox" name="" id="" class="me-2 mt-1"></h6> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pb-0 justify-content-start border-0" align="left">
                    <button type="submit" class="btn btn-primary pe-3" id="save-billing" disabled><i data-feather="check"></i> Save</button>
                    <button type="button" class="btn btn-secondary pe-3" data-bs-dismiss="modal"><i data-feather="x"></i> Close</button>
                </div>
            </form>
        </div>
    </div>
</div>