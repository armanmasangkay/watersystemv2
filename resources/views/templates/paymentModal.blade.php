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
                            <input class="form-control-plaintext ps-2" style="font-weight: bold; font-size: 20px;" id="meter_reading" name="meter_reading" type="number" placeholder="Meter reading" min=0 readOnly value="{{ isset($customer) ? ($customer['balance'] != null  ? $customer['balance']->reading_meter:'') : '' }}">
                        </div>
                        <div class="col-lg-4 col-md-6 mb-sm-2 ps-md-0 pe-md-0 ps-sm-1">
                            <label class='text-muted'>Previous Balance</label>
                            <input class="form-control-plaintext ps-2" style="font-weight: bold; font-size: 20px;" id="curr_balance" name="curr_balance" type="text" placeholder="Meter reading" min=0 readonly value="{{ isset($customer) ? ($customer['balance'] != null ? \App\Classes\Facades\NumberHelper::toAccounting($customer['balance']->balance):'0.00') : '0.00' }}">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-4 col-md-6 pe-md-0">
                            <label class='text-muted'>Reading Date</label>
                            <input type="text" class="form-control-plaintext ps-2" style="font-weight: bold; font-size: 20px;" name="date" value="" readonly>
                        </div>
                    </div>
                    <div class='row px-md-2 mb-2 mt-2'>
                        <div class='col-6 col-md-3 col-lg-2 col-xl-1 mt-2 pe-md-1 ps-md-1 ps-lg-1 pe-sm-1 pe-1'>

                            <small class='text-primary'>From</small>
                            <input type="text" class="form-control-plaintext" style="font-weight: bold; font-size: 20px;" name="from" readonly>

                        </div>
                        <div class='col-6 col-md-3 col-lg-2 col-xl-1 mt-2 ps-md-0 pe-md-0 ps-sm-0 ps-0'>
                            <small class='text-primary'>To</small>
                            <input type="text" class="form-control-plaintext" style="font-weight: bold; font-size: 20px;" name="to" readonly>
                        </div>

                        <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-lg-2 mt-md-2 px-lg-1 pe-sm-1 ps-md-1 pe-1'>
                            <small class='text-muted'>Meter Reading</small>
                            <input class='form-control-plaintext ps-2' style="font-weight: bold; font-size: 20px;" type='number' min=0 id="read_meter" name="read_meter" readonly>
                        </div>

                        <div class='col-6 col-md-6 col-lg-4 col-xl-1 mt-2 mt-lg-2 mt-md-2 px-lg-0 ps-md-1 pe-md-0 ps-sm-0 ps-0'>
                            <small class='text-muted'>Consumption</small>
                            <input class='form-control-plaintext ps-2' style="font-weight: bold; font-size: 20px;" type='number' id="consumpt" name="consumpt" min=0 readOnly placeholder="0">
                        </div>
                        <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-2 px-lg-1 pe-sm-1 ps-md-1 pe-1'>
                            <small class='text-muted'>Amount</small>
                            <input class='form-control-plaintext ps-2' style="font-weight: bold; font-size: 20px;" type='number' id="consumpt_amount" name="consumpt_amount" min=0 readOnly placeholder="0.00">
                        </div>
                        <div class='col-6 col-md-6 col-lg-4 col-xl-1 mt-2 mt-md-2 px-lg-0 ps-md-1 pe-md-0 ps-sm-0 ps-0'>
                            <small class='text-muted'>Surcharge</small>
                            <input class='form-control-plaintext ps-2' style="font-weight: bold; font-size: 20px;" type='number' name="sur_amount" id="sur_amount" value='0.00' min=0 readonly>
                        </div>
                        <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-2 px-lg-1 pe-sm-1 ps-md-1 pe-1'>
                            <small class='text-muted'>Meter IPS Balance</small>
                            <input class='form-control-plaintext ps-2' style="font-weight: bold; font-size: 20px;" type='number' name="meterIPS" id="meterIPS" placeholder='0.00' min=0 value="" readonly>
                        </div>
                        <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-2 ps-lg-0 ps-md-1 pe-lg-1 ps-sm-0 pe-md-0 ps-0'>
                            <small class='text-muted'>Total Balance</small>
                            <input class='form-control-plaintext ps-2' style="font-weight: bold; font-size: 20px;" type='number' id="totalAmount" name="totalAmount" placeholder='0.00' min=0 readonly>
                        </div>
                    </div>
                    <h5 class="text-muted mt-4">Payments Input</h5>
                    <div class="row mt-3">
                        <div class="col-md-4 pe-md-0">
                            <label class='text-muted'>Payment Date (dd/mm/yyyy) <span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="w-100 w-md-75 border-top-0 border-end-0 border-start-0 border-secondary rounded-0" style="cursor: pointer;" id="carbon_date" readonly value="{{ \Carbon\Carbon::now()->format('F d, Y') }}">
                            <input type="hidden" class="border-0 date" name="payment_date" id="payment_date" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-4 col-md-6 pe-md-0">
                            <small class='text-muted'>Enter OR Number <span class="text-danger"><strong>*</strong></span></small>
                            <input type="text" class="w-75 form-control border-top-0 border-end-0 border-start-0 border-secondary rounded-0" placeholder="xxxx" name="orNum" id="orNum">
                        </div>
                        <div class="col-lg-4 col-md-6 ps-md-1 pe-md-1">
                            <small class='text-muted'>Remaining Balance</small>
                            <input type="number" class="w-50 form-control-plaintext ps-2" style="font-weight: bold; font-size: 20px; color:black;" placeholder="0.00" name="remaining_bal" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-4 col-md-6 pe-md-0">
                            <small class='text-muted'>Enter Payment Amount <span class="text-danger"><strong>*</strong></span></small>
                            <input type="number" class="w-75 form-control border-top-0 border-end-0 border-start-0 border-secondary rounded-0" placeholder="0.00" name="inputedAmount" id="inputedAmount">
                        </div>
                        <!-- <div class="col-lg-3 col-md-6 ps-md-0">
                            <small class='text-muted'>Advance Payment</small>
                            <input type="number" class="form-control" placeholder="0.00" name="advance_payment " readonly>
                        </div> -->
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
