import { showConfirmation } from "../functions/showConfirmation.js";
import { showToast } from "../functions/showToast.js";
import isOkay from "../utils/isOkay.js";
import setData from "../utils/setData.js";
const setTable = () => {
    $(document)
        .off("click", "#acceptBtn")
        .on("click", "#acceptBtn", (e) => {
        const id = e.currentTarget.dataset.id;
        const type = e.currentTarget.dataset.type;
        const processed_by = e.currentTarget.dataset.processed_by;
        const data = setData({
            id,
            status: 'Approved'
        }, 'put');
        showConfirmation({
            message: "Are you sure you want to accept this request?",
            cancelText: "Cancel",
            confirmText: "Accept",
            confirmVariant: "warning",
            onConfirm() {
                axios.post("/api/request.php", data)
                    .then((result) => {
                    const data = result.data;
                    showToast(data.message, {
                        variant: isOkay(data.status) ? "success" : "error",
                    });
                    const reportData = setData({
                        request_id: id,
                        status: "Pending",
                        process_by: processed_by
                    });
                    axios.post("/api/reports.php", reportData).then((result) => {
                        return console.table(result);
                    });
                    if (isOkay(data.status)) {
                        showConfirmation({
                            message: "Request approved successfully! Do you want to print the document now?",
                            cancelText: "Later",
                            confirmText: "Print Now",
                            confirmVariant: "primary",
                            onConfirm() {
                                window.open(`/documents/${type}.php?id=${id}`, '_blank');
                            },
                        });
                    }
                    $("#requestsTable").load(`${window.location.href} #requestsTable`);
                    setTable();
                });
            }
        });
    });
    $(document)
        .off("click", "#rejectBtn")
        .on("click", "#rejectBtn", (e) => {
        const id = e.currentTarget.dataset.id;
        const data = setData({
            id,
            status: 'Rejected'
        }, 'put');
        showConfirmation({
            message: "Are you sure you want to reject this request?",
            cancelText: "Cancel",
            confirmText: "Reject",
            confirmVariant: "danger",
            onConfirm() {
                axios.post("/api/request.php", data)
                    .then((result) => {
                    const data = result.data;
                    showToast(data.message, {
                        variant: isOkay(data.status) ? "success" : "error",
                    });
                    $("#requestsTable").load(`${window.location.href} #requestsTable`);
                    setTable();
                });
            },
        });
    });
    $(document)
        .off("click", "#printBtn")
        .on("click", "#printBtn", (e) => {
        const id = e.currentTarget.dataset.id;
        const type = e.currentTarget.dataset.type;
        window.open(`/documents/${type}.php?id=${id}`, '_blank');
    });
};
setTable();
