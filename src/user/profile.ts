import { ResultDataType } from "../types/ResultData";
import { showToast } from "../functions/showToast.js";
import isOkay from "../utils/isOkay.js";
import setData from "../utils/setData.js";
import { showConfirmation } from "../functions/showConfirmation.js";

$("#logoutBtn").on("click", (e) => {
	e.preventDefault();

	showConfirmation({
		'message': "Are you sure you want to logut?",
		'confirmText': "Logout",
		'onConfirm': () => {
			axios.post('/api/user-auth.php', setData({}, 'delete'))
				.then((result) => {
					const data = result.data as ResultDataType;
					if (isOkay(data.status)) {
						return window.location.reload();
					}
		
					return showToast(data.message, { variant: "error" });
				})
		}
	})

});