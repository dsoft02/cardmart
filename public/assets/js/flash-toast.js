(function () {
    const container = document.getElementById('toastContainer');
    if (!container) return;

    const ICONS = {
        success: 'bx-check-circle',
        error: 'bx-x-circle',
        warning: 'bx-error',
        info: 'bx-info-circle'
    };

    const COLORS = {
        success: 'bg-primary',
        error: 'bg-danger',
        warning: 'bg-warning',
        info: 'bg-info'
    };

    function ucfirst(str = '') {
        return str ? str.charAt(0).toUpperCase() + str.slice(1) : '';
    }

    function escapeHtml(str = '') {
        return String(str)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function showToast(type = 'info', message = '', title = null, delay = 3000) {
        if (!message) return;

        const toast = document.createElement('div');

        toast.className = `bs-toast toast my-2 ${COLORS[type] || 'bg-secondary'}`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        toast.setAttribute('data-bs-delay', String(delay));

        const safeTitle = escapeHtml(title || ucfirst(type));
        const safeMessage = escapeHtml(message);

        toast.innerHTML = `
            <div class="toast-header">
                <i class="icon-base bx ${ICONS[type] || 'bx-bell'} me-2"></i>
        <div class="me-auto fw-medium">${safeTitle}</div>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
      <div class="toast-body">${safeMessage}</div>
        `;

        container.appendChild(toast);

        const bsToast = new bootstrap.Toast(toast);

        bsToast.show();

        toast.addEventListener('hidden.bs.toast', () => toast.remove());
    }

    // Multiple flashes
    if (Array.isArray(window.FLASH_MESSAGES) && window.FLASH_MESSAGES.length) {
        window.FLASH_MESSAGES.forEach(f => {
            showToast(f.type, f.message, f.title);
        });
    }

    // Validation errors (also multiple)
    if (Array.isArray(window.VALIDATION_ERRORS) && window.VALIDATION_ERRORS.length) {
        window.VALIDATION_ERRORS.forEach(msg => showToast('error', msg, 'Error', 5000));
    }

    window.flashToast = showToast;
})();
