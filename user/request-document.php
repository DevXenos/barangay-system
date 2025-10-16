<div class="container py-4">

	<!-- Page Title -->
	<h3 class="mb-4">Document Request</h3>

	<!-- Request Form -->
	<div class="card mb-4 shadow-sm">
		<div class="card-body">
			<h5 class="card-title mb-3">Request Form</h5>

			<form id="requestDocumentForm">
				<div class="row mb-3">
					<div class="col-12">
						<input name="resident_id" hidden class="form-control" type="text" placeholder="ID" value="<?= $user['id'] ?>">
					</div>
				</div>

				<!-- Request For Selection -->
				<div class="row mb-3">
					<div class="col-12 col-md-6">
						<label class="form-label">Request For</label>
						<select class="form-select" id="requestForSelect" name="request_for" required>
							<option value="Self" selected>Self</option>
							<option value="Child">Child</option>
							<option value="Husband/Wife">Husband/Wife</option>
						</select>
					</div>

					<div class="col-12 col-md-6">
						<label class="form-label">Document Type</label>
						<select class="form-select" name="document_type" required>
							<option value="" disabled selected>Choose...</option>
							<option value="barangay_clearance">Barangay Clearance</option>
							<option value="certificate_of_indigency">Certificate of Indigency</option>
							<option value="certificate_of_residency">Certificate of Residency</option>
						</select>
					</div>
				</div>


				<!-- Personal Info: Name + Birthdate + Gender -->
				<div class="row mb-3">
					<div class="col-md-4">
						<label class="form-label">First Name</label>
						<input type="text" class="form-control" name="first_name" value="<?= $user['first_name'] ?>" required>
					</div>
					<div class="col-md-4">
						<label class="form-label">Middle Name</label>
						<input type="text" class="form-control" name="middle_name" value="<?= $user['middle_name'] ?>" required>
					</div>
					<div class="col-md-4">
						<label class="form-label">Last Name</label>
						<input type="text" class="form-control" name="last_name" value="<?= $user['last_name'] ?>" required>
					</div>
				</div>

				<div class="row mb-3">
					<div class="col-12 col-md-4">
						<label class="form-label">Birthdate</label>
						<input type="date" class="form-control" name="birth_date" value="<?= $user['birth_date'] ?>" required>
					</div>
					<div class="col-12 col-md-4">
						<label class="form-label">Gender</label>
						<select class="form-select" name="gender" required>
							<option value="" selected disabled>Choose...</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
						</select>
					</div>
					<div class="col-12 col-md-4">
						<label class="form-label">Civil Status</label>
						<select name="civil_status" class="form-select" required>
							<option value="" selected disabled>Choose...</option>
							<option value="Single">Single</option>
							<option value="Married">Married</option>
							<option value="Widowed">Widowed</option>
							<option value="Separated">Separated</option>
							<option value="Divorced">Divorced</option>
						</select>
					</div>
				</div>

				<!-- Address + Contact -->
				<div class="row mb-3">
					<div class="col-12 col-md-6">
						<label class="form-label">Address</label>
						<input type="text" class="form-control" name="address" value="<?= $user['address'] ?>" required>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label">Contact Number</label>
						<input type="text" class="form-control" name="contact_number" value="<?= $user['contact_number'] ?>" required>
					</div>
				</div>

				<!-- Document Request Details -->
				<div class="row mb-3">
					<div class="col-12">
						<label class="form-label">Purpose / Reason</label>
						<textarea
							class="form-control"
							name="purpose"
							rows="1"
							required
							style="resize: none; overflow:hidden;"
							oninput="
								this.style.height='auto';
								this.style.height=this.scrollHeight+'px';
							"></textarea>
					</div>
				</div>

				<!-- Submit Button -->
				<div class="d-flex justify-content-end">
					<button type="submit" class="btn btn-primary">Submit Request</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="module">
	// Change personal info defaults based on "Request For"
	const requestForSelect = document.getElementById('requestForSelect');
	const firstNameInput = document.querySelector('input[name="first_name"]');
	const middleNameInput = document.querySelector('input[name="middle_name"]');
	const lastNameInput = document.querySelector('input[name="last_name"]');
	const addressInput = document.querySelector('input[name="address"]');
	const contactInput = document.querySelector('input[name="contact_number"]');
	const birthdateInput = document.querySelector('input[name="birth_date"]');
	const genderSelect = document.querySelector('select[name="gender"]');
	const civilStatusSelect = document.querySelector('select[name="civil_status"]');

	requestForSelect.addEventListener('change', function() {
		switch (this.value) {
			case 'Self':
				firstNameInput.value = '<?= $user['first_name'] ?>';
				middleNameInput.value = '<?= $user['middle_name'] ?>';
				lastNameInput.value = '<?= $user['last_name'] ?>';
				addressInput.value = '<?= $user['address'] ?>';
				contactInput.value = '<?= $user['contact_number'] ?>';
				birthdateInput.value = '<?= $user['birth_date'] ?>';
				genderSelect.value = '';
				civilStatusSelect.value = '';
				break;
			case 'Child':
			case 'Husband/Wife':
				firstNameInput.value = '';
				middleNameInput.value = '<?= $user['middle_name'] ?>';
				lastNameInput.value = '<?= $user['last_name'] ?>';
				addressInput.value = '<?= $user['address'] ?>';
				contactInput.value = '<?= $user['contact_number'] ?>';
				birthdateInput.value = '';
				genderSelect.value = '';
				civilStatusSelect.value = '';
				break;
		}
	});

	// Enable Bootstrap tooltips
	const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
	const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl);
	});

	// Auto-select all text when input is focused
	document.querySelectorAll('input, textarea').forEach((el) => {
		el.addEventListener('focus', function() {
			setTimeout(() => this.select(), 0);
		});
	});
</script>

<script type="module" src="./../dist/user/request-document.js"></script>