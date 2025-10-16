type DialogOption<T = Record<string, any>> = {
	onShow?: (context: { form: HTMLFormElement; modal: bootstrap.Modal }) => void;
	onClose?: (context: { form: HTMLFormElement; modal: bootstrap.Modal }) => void;
	onSubmit?: (context: { data: T; form: HTMLFormElement; modal: bootstrap.Modal }) => void;
};

const showDialog = <T = Record<string, any>>(id: string, option?: DialogOption<T>) => {
	const modalEl = document.getElementById(id);
	if (!modalEl) return;

	const modal = new bootstrap.Modal(modalEl, {
		backdrop: 'static',
		keyboard: false,
	});

	let form = modalEl.querySelector('form') as HTMLFormElement | null;

	if (form) {
		// Replace form to clear previous event handlers
		const newForm = form.cloneNode(true) as HTMLFormElement;
		form.parentNode?.replaceChild(newForm, form);
		form = newForm; // <-- now form points to the current one in DOM

		newForm.addEventListener('submit', (e: Event) => {
			e.preventDefault();
			const formData = new FormData(newForm);
			const data = Object.fromEntries(formData.entries()) as T;
			option?.onSubmit?.({ data, form: newForm, modal });
		});
	}

	// Trigger onShow immediately after cloning so it works on the correct form
	if (form && option?.onShow) {
		option.onShow({ form, modal });
	}

	// Handle modal close
	modalEl.addEventListener(
		'hidden.bs.modal',
		() => {
			if (form) {
				option?.onClose?.({ form, modal });
			}
		},
		{ once: true }
	);

	modal.show();
};

export default showDialog;
