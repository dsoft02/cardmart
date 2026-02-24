<div class="col-md-6" data-gateway="stripe">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Stripe</h5>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <label class="form-label">Mode</label>
                <select name="payment_gateways[stripe][mode]" class="form-select">
                    <option value="test" @selected(data_get($settings,'payment_gateways.stripe.mode')==='test')>
                        Test
                    </option>
                    <option value="live" @selected(data_get($settings,'payment_gateways.stripe.mode')==='live')>
                        Live
                    </option>
                </select>
            </div>

            {{-- TEST --}}
            <div class="mb-3">
                <label class="form-label">Test Public Key</label>
                <input class="form-control"
                       name="payment_gateways[stripe][test][public_key]"
                       value="{{ data_get($settings,'payment_gateways.stripe.test.public_key') }}"
                       placeholder="Leave blank to use ENV">
            </div>

            <div class="mb-3">
                <label class="form-label">Test Secret Key</label>
                <input type="password"
                       class="form-control"
                       name="payment_gateways[stripe][test][secret_key]"
                       value="{{ data_get($settings,'payment_gateways.stripe.test.secret_key') }}"
                       placeholder="Leave blank to use ENV">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Test Webhook Secret
                    <small class="text-muted">(optional)</small>
                </label>
                <input type="password"
                       class="form-control"
                       name="payment_gateways[stripe][test][webhook_secret]"
                       value="{{ data_get($settings,'payment_gateways.stripe.test.webhook_secret') }}"
                       placeholder="whsec_...">
            </div>

            <hr>

            {{-- LIVE --}}
            <div class="mb-3">
                <label class="form-label">Live Public Key</label>
                <input class="form-control"
                       name="payment_gateways[stripe][live][public_key]"
                       value="{{ data_get($settings,'payment_gateways.stripe.live.public_key') }}"
                       placeholder="Leave blank to use ENV">
            </div>

            <div class="mb-3">
                <label class="form-label">Live Secret Key</label>
                <input type="password"
                       class="form-control"
                       name="payment_gateways[stripe][live][secret_key]"
                       value="{{ data_get($settings,'payment_gateways.stripe.live.secret_key') }}"
                       placeholder="Leave blank to use ENV">
            </div>

            <div>
                <label class="form-label">
                    Live Webhook Secret
                    <small class="text-muted">(required for production)</small>
                </label>
                <input type="password"
                       class="form-control"
                       name="payment_gateways[stripe][live][webhook_secret]"
                       value="{{ data_get($settings,'payment_gateways.stripe.live.webhook_secret') }}"
                       placeholder="whsec_...">
            </div>

        </div>
    </div>
</div>
