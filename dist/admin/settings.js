import { showToast } from "../functions/showToast.js";
import setData from "../utils/setData.js";
const $form = $("#securityForm");
$form.on("submit", (e) => {
    e.preventDefault();
    const data = setData(e.target, 'put');
    if (data.new_password.trim() !== data.confirm_new_password.trim()) {
        return showToast("Passwords do not match. Please try again.", { variant: "error" });
    }
    axios.post('/api/admin-auth.php', data)
        .then((result) => {
        const data = result.data;
        $form[0].reset();
        showToast(data.message, {
            variant: data.status === 200 ? "success" : "error"
        });
    });
});
