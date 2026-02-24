<div class="col-md-6">
    <div class="card h-100">
        <div class="card-header">
            <h5 class="mb-0">Bookings</h5>
        </div>

        <div class="card-body">

            {{-- Auto approve --}}
            <div class="form-check form-switch mb-4">
                <input class="form-check-input"
                       type="checkbox"
                       name="booking_auto_approve"
                       id="booking_auto_approve"
                       value="1"
                    @checked($settings['booking_auto_approve'])>
                <label class="form-check-label" for="booking_auto_approve">
                    Auto-approve bookings
                </label>
            </div>

            {{-- Notice hours --}}
            <div class="mb-4">
                <label class="form-label">Minimum Notice (hours)</label>
                <input type="number"
                       class="form-control"
                       name="booking_notice_hours"
                       min="0"
                       value="{{ $settings['booking_notice_hours'] }}">
            </div>

            <hr>

            {{-- Free booking limit --}}
            <div>
                <label class="form-label">
                    Free bookings per user
                </label>

                <input type="number"
                       class="form-control"
                       name="free_booking_limit"
                       value="{{ $settings['free_booking_limit'] ?? 1 }}"
                       min="-1">

                <small class="text-muted d-block mt-1">
                    <strong>0</strong> = no free bookings ·
                    <strong>-1</strong> = unlimited
                </small>
            </div>

        </div>
    </div>
</div>
