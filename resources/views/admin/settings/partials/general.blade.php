<div class="col-md-6">
    <div class="card h-100">
        <div class="card-header">
            <h5 class="mb-0">General</h5>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <label class="form-label">Site Name</label>
                <input type="text"
                       class="form-control"
                       name="site_name"
                       value="{{ $settings['site_name'] }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Support Email</label>
                <input type="email"
                       class="form-control"
                       name="site_email"
                       value="{{ $settings['site_email'] }}">
            </div>

            <div>
                <label class="form-label">Support Phone</label>
                <input type="text"
                       class="form-control"
                       name="site_phone"
                       value="{{ $settings['site_phone'] }}">
            </div>

        </div>
    </div>
</div>
