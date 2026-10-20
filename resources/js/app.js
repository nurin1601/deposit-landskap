
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.Swal = Swal;

Alpine.start();

// ── Global confirm handler (delete & duplicate) ──────────────────────────────
document.addEventListener('submit', function (e) {
    const form = e.target;
    if (!form.hasAttribute('data-confirm-delete')) return;

    e.preventDefault();

    const title        = form.dataset.title        || 'Teruskan?';
    const message      = form.dataset.message      || 'Tindakan ini tidak boleh dibatalkan.';
    const icon         = form.dataset.icon         || 'warning';
    const confirmText  = form.dataset.confirmText  || 'Ya, padam';
    const confirmColor = form.dataset.confirmColor || '#dc2626';

    Swal.fire({
        title,
        text: message,
        icon,
        showCancelButton: true,
        confirmButtonText: confirmText,
        cancelButtonText: 'Batal',
        confirmButtonColor: confirmColor,
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
