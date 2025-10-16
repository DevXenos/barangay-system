const formatPhoneNumber = (phoneNumber) => {
    const digits = phoneNumber.replace(/\D/g, "");
    if (digits.length <= 4)
        return digits;
    if (digits.length <= 7)
        return `${digits.slice(0, 4)} ${digits.slice(4)}`;
    return `${digits.slice(0, 4)} ${digits.slice(4, 7)} ${digits.slice(7, 11)}`;
};
export default formatPhoneNumber;
