<div class="col-md-6">
    <div class="card h-100">
        <div class="card-header">
            <h5 class="mb-0">Payment Methods</h5>
        </div>

        <div class="card-body">

            <div class="alert alert-info">
                <strong>Manual payment</strong> is always enabled.
            </div>

            @foreach (['stripe' => 'Stripe', 'paypal' => 'PayPal'] as $key => $label)
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input"
                           type="checkbox"
                           name="payment_methods[{{ $key }}]"
                           id="payment_methods_{{ $key }}"
                           value="1"
                           data-gateway-toggle
                           data-gateway="{{ $key }}"
                        @checked(data_get($settings,"payment_methods.$key"))>

                    <label class="form-check-label" for="payment_methods_{{ $key }}">
                        Enable {{ $label }}
                    </label>
                </div>
            @endforeach

        </div>
    </div>
</div>
