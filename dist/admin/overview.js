import showDialog from "../functions/showDialog.js";
import { showToast } from "../functions/showToast.js";
import setData from "../utils/setData.js";
$("#addNewAnnouncementBtn").on("click", () => {
    showDialog("addNewAnnouncementModal", {
        onSubmit({ data, modal }) {
            const { date } = data;
            const selectedDate = new Date(date);
            const today = new Date();
            selectedDate.setHours(0, 0, 0, 0);
            today.setHours(0, 0, 0, 0);
            if (selectedDate < today) {
                showToast("The selected date has already passed. Please choose a valid future date.");
                return;
            }
            const bodyData = setData(data, 'post');
            axios.post('/api/announcement.php', bodyData)
                .then((result) => {
                const data = result.data;
                showToast(data.message, {
                    variant: (data.status === 200 || data.status === 201) ? "success" : "error"
                });
                $('#announcementContainer').load(window.location.href + " #announcementContainer");
                modal.hide();
            });
        },
    });
});
