<!-- dialog/add-new-announcement.php -->
<div class="modal fade" id="addNewAnnouncementModal" tabindex="-1" aria-labelledby="addAnnouncementLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<form id="announcementForm">
				<div class="modal-header">
					<h5 class="modal-title" id="addAnnouncementLabel">Add New Announcement</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<div class="modal-body">
					<!-- Title -->
					<div class="mb-3">
						<label for="announcementTitle" class="form-label">Title</label>
						<input type="text" name="title" id="announcementTitle" class="form-control" required maxlength="30">
					</div>

					<!-- Description -->
					<div class="mb-3">
						<label for="announcementDescription" class="form-label">Description</label>
						<textarea name="description" id="announcementDescription" rows="3" class="form-control" required></textarea>
					</div>

					<!-- Date -->
					<div class="mb-3">
						<label for="announcementDate" class="form-label">Date</label>
						<input type="date" name="date" id="announcementDate" class="form-control" required>
					</div>

					<!-- Time + Whole Day -->
					<div class="mb-3">
						<label for="announcementTime" class="form-label">Time</label>
						<div class="input-group">
							<input type="time" name="time" id="announcementTime" class="form-control" required>
							<span class="input-group-text bg-light">
								<div class="form-check form-switch m-0">
									<input class="form-check-input" type="checkbox" id="wholeDaySwitch">
									<label class="form-check-label small" for="wholeDaySwitch">Whole day</label>
								</div>
							</span>
						</div>
						<small class="text-muted">If “Whole day” is on, time will be ignored.</small>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Add Announcement</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="module">
	$(document).ready(() => {
		function setupModalHandlers() {
			// Setup once when modal is shown
			$(document).on('shown.bs.modal', '#addNewAnnouncementModal', () => {
				const $timeInput = $("#announcementTime");
				const $wholeDaySwitch = $("#wholeDaySwitch");

				// Reset state
				$wholeDaySwitch.prop("checked", false);
				$timeInput.prop("disabled", false).prop("required", true);

				// Toggle time input behavior
				$wholeDaySwitch.on("change.wholeDay", function() {
					if (this.checked) {
						$timeInput.prop("disabled", true).prop("required", false).val("");
					} else {
						$timeInput.prop("disabled", false).prop("required", true);
					}
				});
			});

			// Reset and clean up after modal hides
			$(document).on('hidden.bs.modal', '#addNewAnnouncementModal', (event) => {
				const $modal = $(event.target);
				const $form = $modal.find('form');
				$form[0].reset(); // Reset fields

				// Remove switch event handler
				$("#wholeDaySwitch").off(".wholeDay");
			});
		}

		setupModalHandlers();

		$(window).on("unload", () => {
			$(document).off('shown.bs.modal', '#addNewAnnouncementModal');
			$(document).off('hidden.bs.modal', '#addNewAnnouncementModal');
			$("#wholeDaySwitch").off(".wholeDay");
		});
	});
</script>