import { ResultDataType } from "./types/ResultData";
import { showToast } from "./functions/showToast.js";
import setData from "./utils/setData.js";

$("#apiTesterForm").on("submit", async (e) => {
	e.preventDefault();

	// Get form data
	const data = setData(e.currentTarget as HTMLFormElement, 'post');

	try {
		// Send request
		const result = await axios.post("/api/staff.php", data);

		// Use your ResultDataType type
		const res = result.data as ResultDataType;
		console.log("Response:", res);
	} catch (error) {
		console.error("API Error:", error);
		showToast("Failed to reach API");
	}
});
