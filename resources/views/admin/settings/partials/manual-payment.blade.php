<div class="col-md-6">
    <div class="card h-100">
        <div class="card-header">
            <h5 class="mb-0">Manual Payment Instructions</h5>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <label class="form-label">Instructions</label>
                <textarea class="form-control"
                          name="manual_payment[instructions]"
                          rows="4"
                          placeholder="Explain how customers should complete manual payments">{{ data_get($settings,'manual_payment.instructions') }}</textarea>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Bank Name</label>
                    <input class="form-control"
                           name="manual_payment[bank_name]"
                           value="{{ data_get($settings,'manual_payment.bank_name') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Account Name</label>
                    <input class="form-control"
                           name="manual_payment[account_name]"
                           value="{{ data_get($settings,'manual_payment.account_name') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Account Number</label>
                    <input class="form-control"
                           name="manual_payment[account_no]"
                           value="{{ data_get($settings,'manual_payment.account_no') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Sort Code</label>
                    <input class="form-control"
                           name="manual_payment[sort_code]"
                           value="{{ data_get($settings,'manual_payment.sort_code') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">SWIFT / BIC</label>
                    <input class="form-control"
                           name="manual_payment[swift_code]"
                           value="{{ data_get($settings,'manual_payment.swift_code') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Interac Email</label>
                    <input class="form-control"
                           type="email"
                           name="manual_payment[interac_email]"
                           value="{{ data_get($settings,'manual_payment.interac_email') }}">
                </div>
            </div>

        </div>
    </div>
</div>
