const formatPhoneNumber = (phoneNumber: string) => {
	const digits = phoneNumber.replace(/\D/g, ""); // remove non-numbers

	// Example: 0912 345 6789 (Philippines mobile format)
	if (digits.length <= 4) return digits;
	if (digits.length <= 7) return `${digits.slice(0, 4)} ${digits.slice(4)}`;
	return `${digits.slice(0, 4)} ${digits.slice(4, 7)} ${digits.slice(7, 11)}`;
};


export default formatPhoneNumber;