<div class="modal modal-fluid fade paymentModal" id="paymentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">           
            <input type="hidden" name="route" value="{{ isset($customer['transactions']) ? route('admin.get-balance', ['id' => $customer['account']]) : '' }}">
            <form action="{{ isset($customer['transactions']) ? route('admin.save-payment', ['id' => $customer['account']]):'' }}" method="post" id="payment-form">
                @csrf
   
                <input type="hidden" name="customer_id" value="{{ isset($customer) ? $customer['account'] : '' }}">
                <input type="hidden" name="curr_transaction_id" value="">

                <div class="modal-header">
                    <h5 class="modal-title text-muted" id="exampleModalLabel"><i data-feather="file"></i><strong>&nbsp; Payments Setup</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <h6 class="text-danger">Note: Fields with (*) is required.</h6>
                    <h5 class="text-muted mt-4">Previous Meter Reading</h5>
                    <div class="row mt-3">
                        <div class="col-lg-4 col-md-6 mb-sm-2 pe-md-1 pe-sm-1">
                            <label class='text-muted'>Meter Reading</label>
                            <input class="form-control" id="meter_reading" name="meter_reading" type="number" placeholder="Meter reading" min=0 readOnly value="{{ isset($customer) ? ($customer['balance'] != null  ? $customer['balance']->reading_meter:'') : '' }}">
                        </div>
                        <div class="col-lg-4 col-md-6 mb-sm-2 ps-md-0 pe-md-0 ps-sm-1">
                            <label class='text-muted'>Previous Balance</label>
                            <input class="form-control" id="curr_balance" name="curr_balance" type="text" placeholder="Meter reading" min=0 readonly value="{{ isset($customer) ? ($customer['balance'] != null ? \App\Classes\Facades\NumberHelper::toAccounting($customer['balance']->balance):'0.00') : '0.00' }}">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-4 col-md-6 pe-md-0">
                            <label class='text-muted'>Reading Date</label>
                            <input type="text" class="form-control" name="date" value="" readonly>
                        </div>
                    </div>
                    <div class='row px-md-2 mb-2 mt-2'>
                        <div class='col-6 col-md-3 col-lg-2 col-xl-1 mt-2 pe-md-1 ps-md-1 ps-lg-1 pe-sm-1 pe-1'>

                            <small class='text-primary'>From</small>
                            <input type="text" class="form-control" name="from" readonly>

                        </div>
                        <div class='col-6 col-md-3 col-lg-2 col-xl-1 mt-2 ps-md-0 pe-md-0 ps-sm-0 ps-0'>
                            <small class='text-primary'>To</small>
                            <input type="text" class="form-control" name="to" readonly>
                        </div>

                        <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-lg-2 mt-md-2 px-lg-1 pe-sm-1 ps-md-1 pe-1'>
                            <small class='text-muted'>Meter Reading</small>
                            <input class='form-control' type='number' min=0 id="read_meter" name="read_meter" readonly>
                        </div>

                        <div class='col-6 col-md-6 col-lg-4 col-xl-1 mt-2 mt-lg-2 mt-md-2 px-lg-0 ps-md-1 pe-md-0 ps-sm-0 ps-0'>
                            <small class='text-muted'>Consumption</small>
                            <input class='form-control' type='number' id="consumpt" name="consumpt" min=0 readOnly placeholder="0">
                        </div>
                        <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-2 px-lg-1 pe-sm-1 ps-md-1 pe-1'>
                            <small class='text-muted'>Amount</small>
                            <input class='form-control' type='number' id="consumpt_amount" name="consumpt_amount" min=0 readOnly placeholder="0.00">
                        </div>
                        <div class='col-6 col-md-6 col-lg-4 col-xl-1 mt-2 mt-md-2 px-lg-0 ps-md-1 pe-md-0 ps-sm-0 ps-0'>
                            <small class='text-muted'>Surcharge</small>
                            <input class='form-control' type='number' name="sur_amount" id="sur_amount" value='0.00' min=0 readonly>
                        </div>
                        <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-2 px-lg-1 pe-sm-1 ps-md-1 pe-1'>
                            <small class='text-muted'>Meter IPS Balance</small>
                            <input class='form-control' type='number' name="meterIPS" id="meterIPS" placeholder='0.00' min=0 value="" readonly>
                        </div>
                        <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-2 ps-lg-0 ps-md-1 pe-lg-1 ps-sm-0 pe-md-0 ps-0'>
                            <small class='text-muted'>Total Balance</small>
                            <input class='form-control' type='number' id="totalAmount" name="totalAmount" placeholder='0.00' min=0 readonly>
                        </div>
                    </div>
                    <h5 class="text-muted mt-4">Payments Input</h5>
                    <div class="row mt-3">
                        <div class="col-md-4 pe-md-0">
                            <label class='text-muted'>Payment Date (dd/mm/yyyy) <span class="text-danger"><strong>*</strong></span></label>
                            <div class="form-control date d-flex justify-content-between align-items-center input" id="datepicker">
                                <input type="text" class="w-100 border-0" id="carbon_date" readonly value="{{ \Carbon\Carbon::now()->format('F d, Y') }}">
                                <span class="input-group-addon calendar"><i data-feather="calendar" width="20"></i></span>
                                <input type="hidden" class="border-0 date" name="payment_date" id="payment_date" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-4 col-md-6 pe-md-0">
                            <small class='text-muted'>Enter OR Number <span class="text-danger"><strong>*</strong></span></small>
                            <input type="text" class="form-control" placeholder="0.00" name="orNum" id="orNum">
                        </div>
                        <div class="col-lg-4 col-md-6 ps-md-1 pe-md-1">
                            <small class='text-muted'>Remaining Balance</small>
                            <input type="number" class="form-control" placeholder="0.00" name="remaining_bal" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-4 col-md-6 pe-md-0">
                            <small class='text-muted'>Enter Payment Amount <span class="text-danger"><strong>*</strong></span></small>
                            <input type="number" class="form-control" placeholder="0.00" name="inputedAmount" id="inputedAmount">
                        </div>
                        <div class="col-lg-4 col-md-6 ps-md-1 pe-md-1">
                            <small class='text-muted'>Change</small>
                            <input type="number" class="form-control" placeholder="0.00" name="change" readonly>
                        </div>
                        <!-- <div class="col-lg-3 col-md-6 ps-md-0">
                            <small class='text-muted'>Advance Payment</small>
                            <input type="number" class="form-control" placeholder="0.00" name="advance_payment " readonly>
                        </div> -->
                    </div>
                    <!-- <div class="row mt-3">
                        <div class="col-md-12 pe-md-0 d-flex justify-content-start align-items-center">
                            <input name="override" id="override" type="checkbox">
                            <label class='text-muted ms-2'>Add change as advance payment ?</label>
                        </div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i data-feather="x"></i> Close</button>
                    <button type="submit" class="btn btn-primary" id="save-payment" disabled><i data-feather="check"></i> Save Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>
