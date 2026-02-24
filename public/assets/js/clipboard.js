document.addEventListener('DOMContentLoaded', function () {
    const clipboard = new ClipboardJS('.copy-btn');

    clipboard.on('success', function (e) {
        const btn = e.trigger;
        btn.innerHTML = '<i class="bx bx-check"></i>';
        setTimeout(() => {
            btn.innerHTML = '<i class="bx bx-copy"></i>';
        }, 1500);
        e.clearSelection();
    });

});
