export function showConfirmation({ message, onConfirm, confirmText = 'Yes, Confirm', cancelText = 'Cancel', confirmVariant = 'danger', cancelVariant = 'secondary', }) {
    const modalEl = document.getElementById('confirmationModal');
    const modal = new bootstrap.Modal(modalEl);
    const msgEl = modalEl.querySelector('#confirmationMessage');
    const confirmBtn = modalEl.querySelector('#confirmActionBtn');
    const footerEl = modalEl.querySelector('.modal-footer');
    const cancelBtn = footerEl.querySelector('button[data-bs-dismiss="modal"]');
    msgEl.textContent = message;
    confirmBtn.textContent = confirmText;
    cancelBtn.textContent = cancelText;
    confirmBtn.className = `btn btn-${confirmVariant}`;
    cancelBtn.className = `btn btn-${cancelVariant}`;
    const newConfirmBtn = confirmBtn.cloneNode(true);
    confirmBtn.parentNode?.replaceChild(newConfirmBtn, confirmBtn);
    newConfirmBtn.addEventListener('click', () => {
        onConfirm();
        modal.hide();
    });
    modal.show();
}
