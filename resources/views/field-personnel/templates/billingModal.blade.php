<div class="modal modal-fluid fade" id="ledgerSetupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('admin.save-meter-billing') }}" method="post" id="billing-form">
                @csrf
                <input type="hidden" name="connection_type" value="{{ isset($customer) ? $customer['connection_type'] : ''}}">
                <input type="hidden" name="min_rates" value="{{ isset($rates) ? $rates['min_rate'] : '0'}}">
                <input type="hidden" name="billing_excess_rate" value="{{ isset($rates) ? $rates['excess_rates'] : '0'}}">
                <input type="hidden" name="max_range" value="{{ isset($rates) ? $rates['max_range'] : '0'}}">
                <input type="hidden" name="or_num" value="{{ isset($customer) ? (isset($customer['balance']->payment_or_no) ? $customer['balance']->payment_or_no : '') : ''}}">
                <input type="hidden" name="surcharge" value="{{ isset($surcharge) ? $surcharge : '0'}}">
                <input type="hidden" name="customer_id" value="{{ isset($customer) ? $customer['account'] : '' }}">
                <input type="hidden" name="current_transaction_id" value="{{ isset($current_transaction_id) ? $current_transaction_id : '' }}">
                <input id="meter-reading" name="meter_reading" type="hidden" placeholder="Meter reading" min=0 readOnly value="{{ isset($customer) ? (isset($customer["balance"]->reading_meter) ? $customer["balance"]->reading_meter : '') : '' }}">
                <input id="cur_balance" name="cur_balance" type="hidden" placeholder="Meter reading" min=0 readonly value="{{ isset($customer) ? (isset($customer["balance"]->balance) ? toAccounting($customer["balance"]->balance) : '0.00') : '0.00' }}">
                <input type="hidden" name='current_month' id='current-month' value="{{ isset($last_date) ? \Carbon\Carbon::parse($last_date)->format('M d') : '' }}">
                <input type="hidden" name='next_month' id='next-month' value="{{ isset($last_date) ? \Carbon\Carbon::parse($last_date)->addMonths(1)->format('M d, Y') : '' }}">
                <input class='form-control' type='hidden' id="consumption" name="consumption" min=0 readOnly placeholder="0">
                <input class='form-control' type='hidden' id="amount" name="amount" min=0 readOnly placeholder="0.00">
                <input class='form-control' type='hidden' name="surcharge_amount" id="surcharge_amount" value='0.00' min=0 readonly>
                <input class='form-control' type='hidden' name="meter_ips" id="meter-ips" placeholder='0.00' min=0 value="{{ isset($customer) ? (isset($customer["balance"]->billing_meter_ips) ? toAccounting($customer["balance"]->billing_meter_ips) : '0.00') : '0.00' }}">
                <input class='form-control' type='hidden' id="total" name="total" placeholder='0.00' min=0 readonly>
                <input type="hidden" name="id" value="{{ Auth::id() }}">

                <div class="modal-header border-0">
                    <h5 class="modal-title text-muted" id="exampleModalLabel"><i data-feather="file"></i><strong>&nbsp; Billing Setup</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <p class="text-danger">Note: Fields with (*) is required.</p>
                    <h3 class="text-muted mt-4"><strong>Meter Reading</strong></h3>
                    <div class="row mt-3 mb-2 px-3">
                        <div class="col-lg-4 col-md-6 mb-sm-2 pe-md-1 pe-sm-1">
                            <label class='text-muted'>Enter Meter Reading <span class="text-danger">*</span></label>
                            <input class="form-control mt-1" id="reading_meter" name="reading_meter" type="number" placeholder="0" min=0 value="">
                        </div>
                        <div class="col-lg-4 col-md-6 mb-sm-2 ps-md-0 pe-md-0 ps-sm-1">
                            <label class='text-muted mt-2'>Reading Date <span class="text-danger">*</span></label>
                            <input class="form-control mt-1" id="read-date" name="read_date" type="text" placeholder="mm/dd/yyyy" min=0 readonly value="{{ \Carbon\Carbon::parse(date('Y-m-d'))->format('F d, Y') }}">
                            <p class="text-info pb-0 mb-1" style="font-size: 13px;">This date is be based on your device setup date.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pb-0 justify-content-start border-0">
                    <button type="submit" class="btn btn-primary pe-3" id="save-billing" disabled><i data-feather="check"></i> Save</button>
                    <button type="button" class="btn btn-secondary pe-3" data-bs-dismiss="modal"><i data-feather="x"></i> Close</button>
                </div>
            </form>
        </div>
    </div>
</div>