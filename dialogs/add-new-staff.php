<!-- dialog/add-new-staff.php -->
<div class="modal fade" id="addNewStaffModal" tabindex="-1" aria-labelledby="addNewStaffLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<form id="addStaffForm">
				<div class="modal-header">
					<h5 class="modal-title" id="addNewStaffLabel">Add New Staff</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<div class="modal-body">
					<div class="mb-3">
						<label for="staffFirstName" class="form-label">First Name</label>
						<input type="text" name="first_name" class="form-control" id="staffFirstName" required>
					</div>

					<div class="mb-3">
						<label for="staffLastName" class="form-label">Last Name</label>
						<input type="text" name="last_name" class="form-control" id="staffLastName" required>
					</div>

					<div class="mb-3">
						<label for="staffEmail" class="form-label">Email</label>
						<input type="email" name="email" class="form-control" id="staffEmail" required readonly value="@barangay.gov.ph">
					</div>

					<div class="mb-3">
						<label for="staffNumber" class="form-label">Phone Number</label>
						<input type="phone-number" name="phone_number" class="form-control" id="staffNumber" required>
					</div>

					<div class="mb-3">
						<label for="staffRole" class="form-label">Role</label>
						<select name="role" id="staffRole" class="form-select" required>
							<option value="" selected disabled>Select role</option>
							<option value="Staff">Staff</option>
							<option value="Administrator">Administrator</option>
						</select>
					</div>

					<div class="mb-3">
						<label for="staffPassword" class="form-label">Password</label>
						<input type="password" name="password" class="form-control" id="staffPassword" required>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Add Staff</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="module">
	import formatPhoneNumber from './../dist/utils/formatPhoneNumber.js';

	$(document).ready(() => {
		function setupAddStaffModal() {
			// When modal opens
			$(document).on('shown.bs.modal', '#addNewStaffModal', (event) => {
				const $modal = $(event.target);
				const $firstName = $modal.find('#staffFirstName');
				const $lastName = $modal.find('#staffLastName');
				const $email = $modal.find('#staffEmail');
				const $staffNumber = $modal.find('#staffNumber');

				// Auto-generate email
				const updateEmail = () => {
					const first = $firstName.val().trim().toLowerCase().replace(/\s+/g, '');
					const last = $lastName.val().trim().toLowerCase().replace(/\s+/g, '');
					$email.val((first || last) ? `${first}.${last}@barangay.gov.ph` : '@barangay.gov.ph');
				};

				$firstName.on('input.staffModal', updateEmail);
				$lastName.on('input.staffModal', updateEmail);

				// Format phone number
				$staffNumber.on('input.staffModal', (e) => {
					const value = e.target.value.replace(/\D/g, '');
					e.target.value = formatPhoneNumber(value);
				});
			});

			// When modal closes
			$(document).on('hidden.bs.modal', '#addNewStaffModal', (event) => {

				// Reset Title
				$('#addNewStaffLabel').text("Add New Staff");

				const $modal = $(event.target);
				const $form = $modal.find('form');
				const $email = $form.find('#staffEmail');

				$form[0].reset();
				$email.val('@barangay.gov.ph');

				// Clean up all event handlers for this modal only
				$('#staffFirstName, #staffLastName, #staffNumber').off('.staffModal');
			});
		}

		setupAddStaffModal();

		// Auto cleanup on page unload (avoid memory leaks)
		$(window).on('unload', () => {
			$(document).off('shown.bs.modal', '#addNewStaffModal');
			$(document).off('hidden.bs.modal', '#addNewStaffModal');
			$('#staffFirstName, #staffLastName, #staffNumber').off('.staffModal');
		});
	});
</script>