const setData = (input, action = 'post') => {
    let data = {};
    if (input instanceof HTMLFormElement) {
        const formData = new FormData(input);
        data = Object.fromEntries(formData.entries());
    }
    else if (typeof input === 'object' && input !== null) {
        data = { ...input };
    }
    return {
        action,
        ...data
    };
};
export default setData;
