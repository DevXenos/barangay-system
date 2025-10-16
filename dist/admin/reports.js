import setData from "../utils/setData.js";
import { showToast } from "../functions/showToast.js";
import isOkay from "../utils/isOkay.js";
import { showConfirmation } from "../functions/showConfirmation.js";
const handle = () => {
    $(".mark-paid-form")
        .off('submit')
        .on("submit", (e) => {
        e.preventDefault();
        showConfirmation({
            message: "Are you sure you want to mark this as Paid?",
            confirmVariant: "warning",
            confirmText: "Confirm",
            onConfirm() {
                const data = setData(e.target, 'put');
                axios.post("/api/reports.php", data)
                    .then((result) => {
                    const data = result.data;
                    showToast(data.message, {
                        variant: isOkay(data.status) ? "success" : "error"
                    });
                    $("#reportsTableContainer").load(`${window.location.href} #reportsTableContainer`);
                });
                handle();
            }
        });
    });
};
handle();
