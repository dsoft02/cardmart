<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-gateway-toggle]').forEach(toggle => {
            const gateway = toggle.dataset.gateway;

            const sync = () => {
                document
                    .querySelectorAll(`[data-gateway="${gateway}"] input, [data-gateway="${gateway}"] select`)
                    .forEach(el => el.disabled = !toggle.checked);
            };

            toggle.addEventListener('change', sync);
            sync();
        });
    });
</script>
