<div class="modal modal-fluid fade" id="ledgerSetupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('admin.save-billing') }}" method="post" id="billing-form">
                @csrf
                <input type="hidden" name="connection_type" value="{{ isset($customer)?$customer['connection_type'] : ''}}">
                <input type="hidden" name="min_rates" value="{{ isset($rates) ? $rates['min_rate'] : '0'}}">
                <input type="hidden" name="billing_excess_rate" value="{{ isset($rates) ? $rates['excess_rates'] : '0'}}">
                <input type="hidden" name="max_range" value="{{ isset($rates) ? $rates['max_range'] : '0'}}">
                <input type="hidden" name="or_num" value="{{ isset($customer) ? ($customer['balance'] != null ? $customer['balance']->payment_or_no : '') : ''}}">
                <input type="hidden" name="surcharge" value="{{ isset($surcharge) ? $surcharge : '0'}}">
                <input type="hidden" name="customer_id" value="{{ isset($customer) ? $customer['account'] : '' }}">
                <input type="hidden" name="current_transaction_id" value="{{ isset($current_transaction_id) ? $current_transaction_id : '' }}">
                <input type="hidden" name="rd_date" value="{{ $customer['balance'] != null ? $customer['balance']->period_covered : '' }}">

                <div class="modal-header">
                    <h5 class="modal-title text-muted" id="exampleModalLabel"><i data-feather="file"></i><strong>&nbsp; New Billing Setup</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <h6 class="text-danger">Note: Fields with (*) is required.</h6>
                    <h5 class="text-muted mt-4">Previous Meter Reading</h5>
                    <div class="row mt-3">
                        <div class="col-lg-4 col-md-6 mb-sm-2 pe-md-1 pe-sm-1">
                            <label class='text-muted'>Meter Reading</label>
                            <input class="form-control" id="meter-reading" name="meter_reading" type="number" placeholder="Meter reading" min=0 readOnly value="{{ isset($customer) ? ($customer['balance'] != null ? $customer['balance']->reading_meter : '0.00') : '0.00' }}">
                        </div>
                        <div class="col-lg-4 col-md-6 mb-sm-2 ps-md-0 pe-md-0 ps-sm-1">
                            <label class='text-muted'>Balance</label>
                            <input class="form-control" id="cur_balance" name="cur_balance" type="text" placeholder="Meter reading" min=0 readonly value="{{ isset($customer) ? ($customer['balance'] != null ? \App\Classes\Facades\NumberHelper::toAccounting($customer['balance']->balance) : '0.00') : '0.00' }}">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-4 pe-md-0">
                            <label class='text-muted'>Reading Date</label>
                            <input type="text" class="form-control" name="date" value="{{ isset($customer) ? ($customer['balance'] != null ? \Carbon\Carbon::parse($customer['balance']->reading_date)->format('F d, Y') : \Carbon\Carbon::parse(date('Y-m-d'))->format('F d, Y')) : '' }}" readonly>
                        </div>
                    </div>

                    <h5 class="text-muted mt-4">Current Meter Reading</h5>
                    <div class="row mt-3">
                        <div class="col-md-4 pe-md-0">
                            <label class='text-muted'>Reading date (dd/mm/yyyy) <span class="text-danger"><strong>*</strong></span></label>
                            <div class="form-control date d-flex justify-content-between align-items-center input" id="datepicker">
                                <input type="text" class="w-100 border-0" id="carbon_date_billing" readonly value="{{ \Carbon\Carbon::now()->format('F d, Y') }}">
                                <span class="input-group-addon calendar"><i data-feather="calendar" width="20"></i></span>
                                <input type="hidden" class="border-0 date" name="reading_date" id="reading_date" readonly>
                            </div>
                        </div>
                    </div>
                    <div class='row px-md-2 mb-2 mt-2'>
                        <div class='col-6 col-md-3 col-lg-2 col-xl-1 mt-2 pe-md-1 ps-md-1 ps-lg-1 pe-sm-1 pe-1'>
                            <small class='text-primary'>{{ isset($last_date) ? \Carbon\Carbon::parse($last_date)->format('M, Y') : '' }}</small>
                            <select name='current_month' id='current-month' class='form-select' disabled>
                                @if(isset($customer))
                                @for($i = 1; $i <= \Carbon\Carbon::parse($last_date)->endOfMonth()->format('d'); $i++)
                                <option value="{{ \Carbon\Carbon::parse($last_date)->format('M '.($i < 10 ? '0'.$i : $i)) }}" {{ \Carbon\Carbon::parse($last_date)->format('d') == $i ? 'selected' : '' }}>{{ $i < 10 ? '0'.$i : $i }}</option>
                                @endfor
                                @endif
                            </select>

                        </div>
                        <div class='col-6 col-md-3 col-lg-2 col-xl-1 mt-2 ps-md-0 pe-md-0 ps-sm-0 ps-0'>
                            <small class='text-primary'>{{ isset($customer) ? \Carbon\Carbon::parse($last_date)->addMonths(1)->format('M, Y') : '' }}</small>
                            <select name='next_month' id='next-month' class='form-select' disabled>
                                @if(isset($customer))
                                @for($i = 1; $i <=  \Carbon\Carbon::parse($last_date)->addMonths(1)->endOfMonth()->format('d'); $i++)
                                <option value="{{ \Carbon\Carbon::parse($last_date)->addMonths(1)->format('M '.($i < 10 ? '0'.$i : $i).', Y') }}" 
                                    {{ \Carbon\Carbon::parse($last_date)->format('d') == $i ? 'selected' : '' }}>{{ $i < 10 ? '0'.$i : $i }}</option>
                                @endfor
                                @endif
                            </select>
                        </div>

                        <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-lg-2 mt-md-2 px-lg-1 pe-sm-1 ps-md-1 pe-1'>
                            <small class='text-muted'>Meter Reading <span class="text-danger"><strong>*</strong></span></small>
                            <input class='form-control' type='number' min=0 id="reading_meter" name="reading_meter">
                        </div>

                        <div class='col-6 col-md-6 col-lg-4 col-xl-1 mt-2 mt-lg-2 mt-md-2 px-lg-0 ps-md-1 pe-md-0 ps-sm-0 ps-0'>
                            <small class='text-muted'>Consumption</small>
                            <input class='form-control' type='number' id="consumption" name="consumption" min=0 readOnly placeholder="0">
                        </div>
                        <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-2 px-lg-1 pe-sm-1 ps-md-1 pe-1'>
                            <small class='text-muted'>Amount</small>
                            <input class='form-control' type='number' id="amount" name="amount" min=0 readOnly placeholder="0.00">
                        </div>
                        <div class='col-6 col-md-6 col-lg-4 col-xl-1 mt-2 mt-md-2 px-lg-0 ps-md-1 pe-md-0 ps-sm-0 ps-0'>
                            <small class='text-muted'>Surcharge</small>
                            <input class='form-control' type='number' name="surcharge_amount" id="surcharge_amount" value='0.00' min=0 readonly>
                        </div>
                        <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-2 px-lg-1 pe-sm-1 ps-md-1 pe-1'>
                            <small class='text-muted'>Meter IPS Balance <span class="text-danger"><strong>*</strong></span></small>
                            <input class='form-control' type='number' name="meter_ips" id="meter-ips" placeholder='0.00' min=0 value="{{ isset($customer) ? ($customer['balance'] != null  ? \App\Classes\Facades\NumberHelper::toAccounting($customer['balance']->billing_meter_ips):'0.00' ) : '0.00' }}">
                        </div>
                        <div class='col-6 col-md-6 col-lg-4 col-xl-2 mt-2 mt-md-2 ps-lg-0 ps-md-1 pe-lg-1 ps-sm-0 pe-md-0 ps-0'>
                            <small class='text-muted'>Total</small>
                            <input class='form-control' type='number' id="total" name="total" placeholder='0.00' min=0 readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 pe-md-0 d-flex justify-content-start align-items-center">
                            <input name="override" id="override" type="checkbox">
                            <label class='text-muted ms-2'>Allow override period covered date ?</label>
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
