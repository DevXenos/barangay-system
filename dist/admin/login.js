import { showToast } from "../functions/showToast.js";
import setData from "../utils/setData.js";
$("#adminLoginForm").on("submit", (e) => {
    e.preventDefault();
    const data = setData(e.target, 'get');
    axios.post("/api/admin-auth.php", data)
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
