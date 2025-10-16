const isOkay = (status: number, ) => {
	return status === 201 || status === 200;
}

export default isOkay;