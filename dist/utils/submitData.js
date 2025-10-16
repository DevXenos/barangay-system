const submitData = (form, action = 'post') => {
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    return {
        action,
        ...data,
    };
};
export default submitData;
