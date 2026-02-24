<div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3"></div>

<script>
    // Multi flashes (array)
    const flashes = @json(session('flashes', []));

    // Single flash (object)
    const flash = @json(session('flash'));

    // Shorthand flashes
    const success = @json(session('success'));
    const error = @json(session('error'));
    const info = @json(session('info'));
    const warning = @json(session('warning')); // optional

    // Normalize to an array of messages
    const normalized = [];

    if (Array.isArray(flashes) && flashes.length) {
        flashes.forEach(f => {
            if (!f) return;
            normalized.push({
                type: f.type || 'info',
                title: f.title || null,
                message: f.message || ''
            });
        });
    }

    if (flash) {
        normalized.push({
            type: flash.type || 'info',
            title: flash.title || null,
            message: flash.message || ''
        });
    }

    if (success) normalized.push({type: 'success', title: 'Success', message: success});
    if (error) normalized.push({type: 'error', title: 'Error', message: error});
    if (info) normalized.push({type: 'info', title: 'Info', message: info});
    if (warning) normalized.push({type: 'warning', title: 'Warning', message: warning});

    window.FLASH_MESSAGES = normalized;

    // Validation errors
    window.VALIDATION_ERRORS = @json($errors->all());
</script>
