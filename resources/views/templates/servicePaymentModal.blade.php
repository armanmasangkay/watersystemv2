<div class="modal modal-fluid fade paymentModal" id="servicePaymentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">           
            <form action="{{ route('admin.services-payment-save') }}" method="post" id="payment-form">
                @csrf
                <input type="hidden" name="customer_id" value="">
                <input type="hidden" name="id" value="">
                <div class="modal-header">
                    <h5 class="modal-title text-muted" id="exampleModalLabel"><i data-feather="file"></i><strong>&nbsp; Payments Setup</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <h6 class="text-danger">Note: Fields with (*) is required.</h6>
                    <h5 class="text-muted mt-4">Payments Input</h5>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class='text-muted'>Payment Date (dd/mm/yyyy) <span class="text-danger"><strong>*</strong></span></label>
                            <div class="form-control date d-flex justify-content-between align-items-center input" id="datepicker">
                                <input type="text" class="w-100 border-0" id="carbon_date_service" readonly value="{{ \Carbon\Carbon::now()->format('F d, Y') }}">
                                <span class="input-group-addon calendar"><i data-feather="calendar" width="20"></i></span>
                                <input type="hidden" class="border-0 date" name="payment_date" id="payment_date" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <small class='text-muted'>Enter OR Number <span class="text-danger"><strong>*</strong></span></small>
                            <input type="text" class="form-control" placeholder="xxxx" name="orNum" id="orNum">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <small class='text-muted'>Enter Amount <span class="text-danger"><strong>*</strong></span></small>
                            <input type="text" class="form-control" placeholder="0.00" name="amount" id="amount">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <small class='text-muted'>Enter Payment Amount <span class="text-danger"><strong>*</strong></span></small>
                            <input type="number" class="form-control" placeholder="0.00" name="inputedAmount" id="inputedAmount">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4 pe-md-4">
                            <p class='text-danger' style="font-size: 20px; font-weight: bold;">Change :</p>
                            <input type="number" class="form-control border-0 text-right" placeholder="0.00" name="change" readonly  style="font-size: 28px; font-weight: bold;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i data-feather="x"></i> Close</button>
                    <button type="submit" class="btn btn-primary" id="save-payment" disabled><i data-feather="check"></i> Save Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>
