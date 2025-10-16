type Action = "get" | "delete" | "post" | "put";

type InputData = HTMLFormElement | Record<string, any>;

const setData = <T> (input: InputData, action: Action = 'post') => {
	let data: Record<string, any> = {};

	if (input instanceof HTMLFormElement) {
		const formData = new FormData(input);
		data = Object.fromEntries(formData.entries());
	} else if (typeof input === 'object' && input !== null) {
		data = { ...input };
	}

	return {
		action,
		...data
	} as T & {
		action: Action
	};
};

export default setData;