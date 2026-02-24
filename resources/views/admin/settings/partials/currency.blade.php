<div class="col-md-6">
    <div class="card h-100">
        <div class="card-header">
            <h5 class="mb-0">Currency</h5>
        </div>

        <div class="card-body">
            <label class="form-label">Payment Currency</label>

            <select name="currency" class="form-select">
                @foreach(['CAD','USD','NGN','GBP','EUR'] as $code)
                    <option value="{{ $code }}"
                        @selected($settings['currency'] === $code)>
                        {{ $code }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
