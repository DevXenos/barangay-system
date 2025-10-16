import { showToast } from "./functions/showToast.js";
import { ResultDataType } from "./types/ResultData.js";
import setData from "./utils/setData.js";

$("#registrationForm").on("submit", (e) => {
	e.preventDefault();

	const data = setData(e.target as HTMLFormElement, 'post');

	axios.post('/api/user-auth.php', data)
		.then((result) => {
			const data = result.data as ResultDataType;
			
			if (data.status === 200 || data.status === 201) {
				window.location.reload();
			} else {
				showToast(data.message);
			}
		})
});