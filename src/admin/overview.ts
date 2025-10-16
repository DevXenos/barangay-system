import { Announcement } from "./../types/AnnouncementType";
import { ResultDataType } from "../types/ResultData";
import showDialog from "../functions/showDialog.js";
import { showToast } from "../functions/showToast.js";
import setData from "../utils/setData.js";

$("#addNewAnnouncementBtn").on("click", () => {
	showDialog<Announcement>("addNewAnnouncementModal", {
		onSubmit({ data, modal }) {
			const { date } = data;

			const selectedDate = new Date(date);
			const today = new Date();

			// Normalize to date only (ignore time)
			selectedDate.setHours(0, 0, 0, 0);
			today.setHours(0, 0, 0, 0);

			// Compare
			if (selectedDate < today) {
				showToast("The selected date has already passed. Please choose a valid future date.");
				return;
			}

			const bodyData = setData(data, 'post');

			axios.post('/api/announcement.php', bodyData)
				.then((result) => {
					const data = result.data as ResultDataType;
					showToast(data.message, {
						variant: (data.status === 200 || data.status === 201) ? "success" : "error"
					});

					$('#announcementContainer').load(window.location.href + " #announcementContainer");
					modal.hide();
				})
		},
	});
});
