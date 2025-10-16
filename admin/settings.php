<div class="container py-4 d-flex flex-column gap-3">
	<!-- Page Header -->
	<div class="text-center mb-4">
		<h1 class="fw-bold text-primary">⚙️ Settings</h1>
		<p class="text-muted">Manage your account and keep your profile up to date</p>
	</div>

	<!-- Profile Card on top -->
	<div class="card text-center shadow-sm border-0">
		<div class="card-body d-flex flex-column align-items-center">
			<!-- <img src="https://via.placeholder.com/120" class="rounded-circle mb-3 border border-3 border-primary-subtle" alt="Profile"> -->
			<h4 class="fw-semibold mb-1">
				<?= $admin['first_name'] . ' ' . $admin['last_name']; ?>
			</h4>
			<span class="text-muted">
				<?= $admin['role'] ?>
			</span>
		</div>
	</div>

	<!-- Settings Grid -->
	<div class="row g-3 justify-content-center">
		<!-- Account Info -->
		<div class="col-sm-12 col-lg-6">
			<div class="card shadow-sm border-0 h-100">
				<div class="card-body">
					<h5 class="fw-semibold mb-3 text-primary">
						<i class="bi bi-person-circle me-2"></i>Account Information
					</h5>
					<form>
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="firstName" value="<?= $admin['first_name'] ?>" placeholder="First Name">
							<label for="firstName"><i class="bi bi-person me-2"></i>First Name</label>
						</div>
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="lastName" value="<?= $admin['last_name'] ?>" placeholder="Last Name">
							<label for="lastName"><i class="bi bi-person me-2"></i>Last Name</label>
						</div>
						<div class="form-floating mb-2">
							<input type="email" class="form-control" id="email" value="<?= $admin['email'] ?>" disabled>
							<label for="email"><i class="bi bi-envelope me-2"></i>Email</label>
						</div>
						<div class="small text-muted mb-3">
							<i class="bi bi-info-circle me-1"></i>Contact support to change your email address
						</div>
						<div class="d-grid">
							<button type="submit" class="btn btn-primary">
								<i class="bi bi-check-circle me-2"></i>Save Changes
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- Security -->
		<div class="col-sm-12 col-lg-6">
			<div class="card shadow-sm border-0 h-100">
				<div class="card-body">
					<h5 class="fw-semibold mb-3 text-primary">
						<i class="bi bi-shield-lock me-2"></i>Security
					</h5>
					<form id="securityForm">
						<div class="form-floating mb-3">
							<input name="old_password" type="password" class="form-control" id="currentPass" placeholder="Current Password" required>
							<label for="currentPass"><i class="bi bi-lock me-2"></i>Current Password</label>
						</div>
						<div class="form-floating mb-3">
							<input name="new_password" type="password" class="form-control" id="newPass" placeholder="New Password" required>
							<label for="newPass"><i class="bi bi-key me-2"></i>New Password</label>
						</div>
						<div class="form-floating mb-4">
							<input name="confirm_new_password" type="password" class="form-control" id="confirmPass" placeholder="Confirm Password" required>
							<label for="confirmPass"><i class="bi bi-key-fill me-2"></i>Confirm New Password</label>
						</div>
						<div class="d-grid">
							<button type="submit" class="btn btn-outline-primary">
								<i class="bi bi-arrow-repeat me-2"></i>Update Password
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	.card {
		border-radius: 18px;
		transition: all 0.25s ease;
	}

	.btn {
		margin-top: auto;
		transition: 0.2s ease;
	}

	.profile-card img {
		max-width: 120px;
		height: auto;
	}

	h1,
	h5 {
		letter-spacing: 0.5px;
	}
</style>