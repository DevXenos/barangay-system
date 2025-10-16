const showDialog = (id, option) => {
    const modalEl = document.getElementById(id);
    if (!modalEl)
        return;
    const modal = new bootstrap.Modal(modalEl, {
        backdrop: 'static',
        keyboard: false,
    });
    let form = modalEl.querySelector('form');
    if (form) {
        const newForm = form.cloneNode(true);
        form.parentNode?.replaceChild(newForm, form);
        form = newForm;
        newForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(newForm);
            const data = Object.fromEntries(formData.entries());
            option?.onSubmit?.({ data, form: newForm, modal });
        });
    }
    if (form && option?.onShow) {
        option.onShow({ form, modal });
    }
    modalEl.addEventListener('hidden.bs.modal', () => {
        if (form) {
            option?.onClose?.({ form, modal });
        }
    }, { once: true });
    modal.show();
};
export default showDialog;
