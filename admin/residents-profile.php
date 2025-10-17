<?php
$profile_id = $_GET["profile_id"] ?? null;

$resident = getResidentById($profile_id);

if (!$resident) {
	echo "<div class='alert alert-danger text-center mt-5'>Resident not found.</div>";
	return;
}
?>

<div class="container py-4">
	<!-- Top Back Button -->
	<div class="d-flex mb-3">
		<a href="/admin/residents" class="btn btn-outline-secondary d-flex justify-content-center align-items-center">⬅ Back to Residents</a>
	</div>

	<div class="card shadow-sm mx-auto" style="max-width: 700px;">
		<div class="card-header bg-primary text-white d-flex align-items-center gap-3">
			<i class="bi bi-person-circle fs-3"></i>
			<h4 class="mb-0">Resident Profile</h4>
		</div>

		<div class="card-body">
			<div class="row g-3">
				<div class="col-md-6">
					<label class="form-label fw-semibold">Full Name</label>
					<p class="form-control-plaintext"><?= htmlspecialchars($resident['first_name'] . ' ' . ($resident['middle_name'] ?? '') . ' ' . $resident['last_name']) ?></p>
				</div>

				<div class="col-md-6">
					<label class="form-label fw-semibold">Email</label>
					<p class="form-control-plaintext"><?= htmlspecialchars($resident['email']) ?></p>
				</div>

				<div class="col-md-6">
					<label class="form-label fw-semibold">Contact Number</label>
					<p class="form-control-plaintext"><?= htmlspecialchars($resident['contact_number']) ?></p>
				</div>

				<div class="col-md-6">
					<label class="form-label fw-semibold">Birth Date</label>
					<p class="form-control-plaintext"><?= htmlspecialchars($resident['birth_date']) ?></p>
				</div>

				<div class="col-md-6">
					<label class="form-label fw-semibold">Gender</label>
					<p class="form-control-plaintext"><?= htmlspecialchars($resident['gender']) ?></p>
				</div>

				<div class="col-md-6">
					<label class="form-label fw-semibold">Civil Status</label>
					<p class="form-control-plaintext"><?= htmlspecialchars($resident['civil_status']) ?></p>
				</div>

				<div class="col-12">
					<label class="form-label fw-semibold">Address</label>
					<p class="form-control-plaintext"><?= htmlspecialchars($resident['address']) ?></p>
				</div>

				<div class="col-md-6">
					<label class="form-label fw-semibold">Residency Start Date</label>
					<p class="form-control-plaintext"><?= htmlspecialchars($resident['residency_start_date']) ?></p>
				</div>

				<!-- Bottom Buttons -->
				<div class="col-12 d-flex justify-content-end gap-2 mt-3">
					<a href="/admin/residents" class="btn btn-outline-secondary d-flex justify-content-center align-items-center">⬅ Back</a>
					<button class="btn btn-primary">Edit Profile</button>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	.card-header {
		border-top-left-radius: 0.375rem;
		border-top-right-radius: 0.375rem;
	}

	.form-control-plaintext {
		background-color: #f8f9fa;
		border-radius: 0.375rem;
		padding: 0.5rem 0.75rem;
		margin-bottom: 0.5rem;
	}
</style>