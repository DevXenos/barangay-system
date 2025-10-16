type BootstrapButtonVariant =
	| 'primary'
	| 'secondary'
	| 'success'
	| 'danger'
	| 'warning'
	| 'info'
	| 'light'
	| 'dark';

interface ConfirmationOptions {
	message: string;
	onConfirm: () => void;
	confirmText?: string; // default: 'Yes, Confirm'
	cancelText?: string;  // default: 'Cancel'
	confirmVariant?: BootstrapButtonVariant; // default: 'danger'
	cancelVariant?: BootstrapButtonVariant;  // default: 'secondary'
}

export function showConfirmation({
	message,
	onConfirm,
	confirmText = 'Yes, Confirm',
	cancelText = 'Cancel',
	confirmVariant = 'danger',
	cancelVariant = 'secondary',
}: ConfirmationOptions) {
	const modalEl = document.getElementById('confirmationModal') as HTMLElement;
	const modal = new bootstrap.Modal(modalEl);

	const msgEl = modalEl.querySelector('#confirmationMessage') as HTMLElement;
	const confirmBtn = modalEl.querySelector('#confirmActionBtn') as HTMLButtonElement;

	// Scope cancel button to footer only
	const footerEl = modalEl.querySelector('.modal-footer') as HTMLElement;
	const cancelBtn = footerEl.querySelector('button[data-bs-dismiss="modal"]') as HTMLButtonElement;

	// Set text and variant
	msgEl.textContent = message;
	confirmBtn.textContent = confirmText;
	cancelBtn.textContent = cancelText;

	confirmBtn.className = `btn btn-${confirmVariant}`;
	cancelBtn.className = `btn btn-${cancelVariant}`;

	// Remove previous click listeners safely
	const newConfirmBtn = confirmBtn.cloneNode(true) as HTMLButtonElement;
	confirmBtn.parentNode?.replaceChild(newConfirmBtn, confirmBtn);

	newConfirmBtn.addEventListener('click', () => {
		onConfirm();
		modal.hide();
	});

	modal.show();
}
