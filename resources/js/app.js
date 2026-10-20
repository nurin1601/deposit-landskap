
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

    const title        = form.getAttribute('data-title')         || 'Teruskan?';
    const message      = form.getAttribute('data-message')       || 'Tindakan ini tidak boleh dibatalkan.';
    const icon         = form.getAttribute('data-icon')          || 'warning';
    const confirmText  = form.getAttribute('data-confirm-text')  || 'Ya, padam';
    const confirmColor = form.getAttribute('data-confirm-color') || '#dc2626';

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
