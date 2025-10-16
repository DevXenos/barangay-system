import { showToast } from "../functions/showToast.js";
import setData from "../utils/setData.js";
$("#logoutBtn").on("click", (e) => {
    axios.post("/api/admin-auth.php", setData({}, 'delete'))
        .then((result) => {
        const data = result.data;
        if (data.status !== 200) {
            showToast(data.message);
        }
        else {
            window.location.reload();
        }
    });
});
