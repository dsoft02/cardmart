<div class="col-md-6" data-gateway="paypal">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">PayPal</h5>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <label class="form-label">Mode</label>
                <select name="payment_gateways[paypal][mode]" class="form-select">
                    <option value="test" @selected(data_get($settings,'payment_gateways.paypal.mode')==='test')>
                        Test
                    </option>
                    <option value="live" @selected(data_get($settings,'payment_gateways.paypal.mode')==='live')>
                        Live
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Test Client ID</label>
                <input class="form-control"
                       name="payment_gateways[paypal][test][public_key]"
                       value="{{ data_get($settings,'payment_gateways.paypal.test.public_key') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Test Secret</label>
                <input class="form-control"
                       name="payment_gateways[paypal][test][secret_key]"
                       value="{{ data_get($settings,'payment_gateways.paypal.test.secret_key') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Live Client ID</label>
                <input class="form-control"
                       name="payment_gateways[paypal][live][public_key]"
                       value="{{ data_get($settings,'payment_gateways.paypal.live.public_key') }}">
            </div>

            <div>
                <label class="form-label">Live Secret</label>
                <input class="form-control"
                       name="payment_gateways[paypal][live][secret_key]"
                       value="{{ data_get($settings,'payment_gateways.paypal.live.secret_key') }}">
            </div>

        </div>
    </div>
</div>
