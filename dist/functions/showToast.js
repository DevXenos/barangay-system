const variantStyle = {
    plain: {
        background: "white",
        color: "red",
        boxShadow: "0 0 8px gray",
    },
    success: {
        background: "#28a745",
        color: "#fff",
        boxShadow: "0 0 8px #28a745"
    },
    error: {
        background: "#dc3545",
        color: "#fff",
        boxShadow: "0 0 8px #dc3545"
    },
    warning: {
        background: "#ffc107",
        color: "#212529",
        boxShadow: "0 0 8px #ffc107"
    },
    info: {
        background: "#17a2b8",
        color: "#fff",
        boxShadow: "0 0 8px #17a2b8"
    },
};
export const showToast = (text, option) => {
    const variant = option?.variant ?? "plain";
    const newOption = {
        "stopOnFocus": true,
        'position': "right",
        "gravity": "bottom",
        "duration": 2000,
        style: {
            borderRadius: "5px",
            ...variantStyle[variant]
        },
        ...option,
        text
    };
    return new Toastify(newOption).showToast();
};
