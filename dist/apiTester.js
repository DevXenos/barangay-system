import { showToast } from "./functions/showToast.js";
import setData from "./utils/setData.js";
$("#apiTesterForm").on("submit", async (e) => {
    e.preventDefault();
    const data = setData(e.currentTarget, 'post');
    try {
        const result = await axios.post("/api/staff.php", data);
        const res = result.data;
        console.log("Response:", res);
    }
    catch (error) {
        console.error("API Error:", error);
        showToast("Failed to reach API");
    }
});
