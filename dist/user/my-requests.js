import { showConfirmation } from "../functions/showConfirmation.js";
import { showToast } from "../functions/showToast.js";
import isOkay from "../utils/isOkay.js";
import setData from "../utils/setData.js";
const setHandler = () => {
    $(".cancel-request-btn").off('click').on("click", (e) => {
        showConfirmation({
            'message': "Are you sure you want to cancel this request?",
            "onConfirm": () => {
                const id = e.target.dataset.id;
                const data = setData({ id, 'status': "Cancelled" }, 'put');
                axios.post('/api/request.php', data)
                    .then((result) => {
                    const data = result.data;
                    showToast(data.message, {
                        'variant': isOkay(data.status) ? "success" : "error"
                    });
                    if (isOkay(data.status)) {
                        $("#requestContainer").load(`${window.location.href} #requestContainer`);
                        setHandler();
                    }
                });
            }
        });
    });
};
setHandler();
