import { showToast } from "../functions/showToast.js";
import { ResultDataType } from "../types/ResultData.js";
import isOkay from "../utils/isOkay.js";
import setData from "../utils/setData.js";

const setHandle = () => {
	$("#requestDocumentForm").on("submit", (e) => {
		e.preventDefault();

		const data = setData(e.target as HTMLFormElement, 'post');
	
		axios.post('/api/request.php', data)
			.then((result) => {
				const data = result.data as ResultDataType;
				showToast(data.message, {
					variant: isOkay(data.status) ? "success" : "error"
				});
	
				if (isOkay(data.status)) {
					window.location.replace('/user/my-requests');
				}
			})
	});
}

setHandle();