import { showToast } from "../functions/showToast.js";
import { ResultDataType } from "../types/ResultData.js";
import setData from "../utils/setData.js";

const $form = $("#securityForm");

$form.on("submit", (e) => {
    e.preventDefault();

    // Collect form data
	const data = setData<{ new_password: string; confirm_new_password: string }>(e.target as HTMLFormElement, 'put');
	
	if (data.new_password.trim() !== data.confirm_new_password.trim()) {
        return showToast("Passwords do not match. Please try again.", { variant: "error" });
    }

    axios.post('/api/admin-auth.php', data)
        .then((result) => {
			const data = result.data as ResultDataType;
			
            // Reset form
            ($form[0] as HTMLFormElement).reset();

            showToast(data.message, {
                variant: data.status === 200 ? "success" : "error"
            });
        });
});