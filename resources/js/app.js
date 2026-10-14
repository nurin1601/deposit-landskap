
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.Swal = Swal;

Alpine.start();

// ── Global delete-confirmation handler ──────────────────────────────────────
document.addEventListener('submit', function (e) {
    const form = e.target;
    if (!form.hasAttribute('data-confirm-delete')) return;

    e.preventDefault();

    const title   = form.dataset.title   || 'Padam rekod ini?';
    const message = form.dataset.message || 'Tindakan ini tidak boleh dibatalkan.';

    Swal.fire({
        title,
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, padam',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc2626',
        cancelButtonColor:  '#166534',
        reverseButtons: true,
        focusCancel: true,
        customClass: {
            popup:         'swal-popup-rounded',
            confirmButton: 'swal-btn-danger',
            cancelButton:  'swal-btn-cancel',
        },
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}, true);
