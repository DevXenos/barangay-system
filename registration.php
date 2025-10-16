<?php

require __DIR__ . '/api/_config.php';
require __DIR__ . '/api/_functions.php';

$title = "Registration Form";
include_once './inc/lib.php';

// If user already has a valid token, redirect to dashboard
if (isset($_COOKIE['user_token'])) {
	$token = $_COOKIE['user_token'];
	$stmt = $conn->prepare('SELECT id FROM `residents` WHERE token = ?');
	$stmt->bind_param('s', $token);
	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows > 0) {
		header("Location: /user"); // Redirect to user dashboard
		exit;
	} else {
		// Invalid token, delete cookie
		setcookie('user_token', '', time() - 3600, '/');
	}
}

?>

<body class="bg-light">
	<div class="min-vh-100 d-flex flex-column">
		<div class="row flex-fill g-0 m-0">

			<!-- Left Side: Registration Form -->
			<form id="registrationForm" class="col-sm-12 col-md-6 d-flex flex-column justify-content-center align-content-center px-5 py-4">
				<div class="text-center mb-4">
					<img src="/assets/img/barangay-logo.png" alt="Barangay Logo" width="80" height="80" class="mb-3">
					<h2 class="fw-bold text-primary">Resident Registration</h2>
					<p class="text-muted small">Create your account to access barangay services</p>
				</div>

				<div class="row g-3">
					<!-- First Name -->
					<div class="col-md-12 col-lg-4">
						<div class="form-floating">
							<input name="first_name" type="text" id="firstNameInput" class="form-control rounded-3" placeholder="First Name" required>
							<label for="firstNameInput">First Name</label>
						</div>
					</div>

					<!-- Middle Name -->
					<div class="col-md-12 col-lg-4">
						<div class="form-floating">
							<input name="middle_name" type="text" id="middleNameInput" class="form-control rounded-3" placeholder="Middle Name">
							<label for="middleNameInput">Middle Name</label>
						</div>
					</div>

					<!-- Last Name -->
					<div class="col-md-12 col-lg-4">
						<div class="form-floating">
							<input name="last_name" type="text" id="lastNameInput" class="form-control rounded-3" placeholder="Last Name" required>
							<label for="lastNameInput">Last Name</label>
						</div>
					</div>

					<!-- Email -->
					<div class="col-12">
						<div class="form-floating">
							<input name="email" type="email" id="emailInput" class="form-control rounded-3" placeholder="Email" required>
							<label for="emailInput">Email</label>
						</div>
					</div>

					<!-- Password -->
					<div class="col-md-6">
						<div class="form-floating">
							<input name="password" type="password" id="passwordInput" class="form-control rounded-3" placeholder="Password" required>
							<label for="passwordInput">Password</label>
						</div>
					</div>

					<!-- Confirm Password -->
					<div class="col-md-6">
						<div class="form-floating">
							<input name="confirm_password" type="password" id="confirmPasswordInput" class="form-control rounded-3" placeholder="Confirm Password" required>
							<label for="confirmPasswordInput">Confirm Password</label>
						</div>
					</div>

					<!-- Birthdate -->
					<div class="col-md-6">
						<div class="form-floating">
							<input name="birth_date" type="date" id="birthDateInput" class="form-control rounded-3" placeholder="Birthdate" required>
							<label for="birthDateInput">Birthdate</label>
						</div>
					</div>

					<!-- Contact Number -->
					<div class="col-md-6">
						<div class="form-floating">
							<input name="contact_number" type="text" id="contactNumberInput" class="form-control rounded-3" placeholder="Contact Number" required>
							<label for="contactNumberInput">Contact Number</label>
						</div>
					</div>

					<!-- Gender -->
					<div class="col-md-6">
						<div class="form-floating">
							<select name="gender" id="genderInput" class="form-select rounded-3" required>
								<option value="" selected disabled>Choose...</option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
							</select>
							<label for="genderInput">Gender</label>
						</div>
					</div>

					<!-- Civil Status -->
					<div class="col-md-6">
						<div class="form-floating">
							<select name="civil_status" id="civilStatusInput" class="form-select rounded-3" required>
								<option value="" selected disabled>Choose...</option>
								<option value="Single">Single</option>
								<option value="Married">Married</option>
								<option value="Widowed">Widowed</option>
								<option value="Separated">Separated</option>
							</select>
							<label for="civilStatusInput">Civil Status</label>
						</div>
					</div>

					<!-- Address -->
					<div class="col-12">
						<div class="form-floating">
							<input name="address" type="text" id="addressInput" class="form-control rounded-3" placeholder="Address" required>
							<label for="addressInput">Address</label>
						</div>
					</div>
				</div>

				<!-- Error Display -->
				<div id="registerError" class="text-danger text-center small mt-2"></div>

				<!-- Submit -->
				<div class="mt-4 d-flex flex-column gap-2 align-items-center">
					<button type="submit" class="btn btn-primary py-2 w-100 fw-semibold rounded-3">
						<i class="bi bi-person-plus me-1"></i> Register
					</button>
					<a class="link-primary small text-decoration-none" href="/">Already have an account? <strong>Login</strong></a>
				</div>
			</form>

			<!-- Right Side: Illustration / Accent -->
			<div class="order-1 col-sm-12 col-md-6 bg-primary d-flex flex-column align-items-center justify-content-center text-white text-center p-5 position-relative">

				<!-- Gradient Overlay -->
				<div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient"
					style="background: linear-gradient(135deg, rgba(0,0,0,0.25), rgba(255,255,255,0.1)); mix-blend-mode: overlay;">
				</div>

				<div class="position-relative z-2">
					<i class="bi bi-people-fill fs-1 mb-3 text-white"></i>
					<h2 class="fw-bold">Join Your Barangay Portal</h2>
					<p class="text-white-50 small mb-4">Get easy access to barangay services, certificates, and community news — all in one place.</p>

					<!-- Highlights -->
					<div class="d-flex flex-column align-items-center gap-2 text-white-50 small">
						<div><i class="bi bi-file-earmark-check me-2 text-white"></i>Request certificates anytime</div>
						<div><i class="bi bi-bell me-2 text-white"></i>Stay updated with barangay news</div>
						<div><i class="bi bi-chat-dots me-2 text-white"></i>Connect with barangay officials</div>
					</div>

					<div class="mt-4">
						<small class="text-white-50">Empowering every resident through digital access.</small>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="module" src="./dist/auth.js"></script>
</body>

</html>