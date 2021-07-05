<div class="modal fade" id="surchargeModel" tabindex="-1" aria-labelledby="surchargeModelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h4 class="modal-title" id="surchargeModelLabel">Surcharge Rate</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-4 px-5">
                <form action="{{ route('admin.surcharge-update') }}" id="surcharge_form" method="post">
                    @csrf
                    <label for="rate">Surcharge Rate</label>
<<<<<<< HEAD
                    <input type="number" name="rate" id="rate" class="form-control" placeholder="0.00" min=0.0>
                    <button class="btn btn-primary btn-md mt-3"><i data-feather="save" width="20" class="pb-1"></i> Save</button>
=======
                    <div class="input-group">
                        <input type="number" name="surcharge_rate" id="surcharge_rate" class="form-control" placeholder="0.00">
                        <div class="input-group-text">
                            <span>%</span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-md mt-3"><i data-feather="save" width="20" class="pb-1"></i> Save</button>
>>>>>>> a11ccaab8b72be63cde5a736cd26d68a06a80318
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/surcharge.js')}}" defer></script>
