import { showToast } from "../functions/showToast.js";
import { ResultDataType } from "../types/ResultData.js";
import setData from "../utils/setData.js";

$("#logoutBtn").on("click", (e) => {
	axios.post("/api/admin-auth.php", setData({}, 'delete'))
		.then((result) => {
			const data = result.data as ResultDataType;

			if (data.status !== 200) {
				showToast(data.message);
			} else {
				window.location.reload();
			}
		})
})