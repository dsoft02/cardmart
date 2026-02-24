(function () {
    "use strict";

    $(document).on("click", ".delete-dialog", function (e) {
        e.preventDefault();

        const button = $(this);
        const form = button.closest("form");

        if (!form.length) return;

        const actionName = button.data("action") || "record";
        const title = button.data("title") || `Are you sure you want to delete ${actionName}?`;
        const confirmText = button.data("confirm-text") || "Yes, delete it";
        const cancelText = button.data("cancel-text") || "Cancel";

        Swal.fire({
            title: title,
            text: `This ${actionName} cannot be restored once deleted.`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#696cff",
            cancelButtonColor: "#d33",
            confirmButtonText: confirmText,
            cancelButtonText: cancelText,
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });

    });
})();
