<?php

require __DIR__ . '/api/_config.php';
require __DIR__ . '/api/_functions.php';

$title = "Login";
include_once './inc/lib.php';

// If user already has a valid token, redirect to dashboard
if (isset($_COOKIE['user_token'])) {
	$token = $_COOKIE['user_token'];
	$stmt = $conn->prepare('SELECT id FROM residents WHERE token = :token');
	$stmt->bindValue(':token', $token, SQLITE3_TEXT);
	$result = $stmt->execute();

	if ($result && $result->fetchArray(SQLITE3_ASSOC)) {
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

			<!-- Left: Login Form -->
			<form id="loginForm" class="form col-sm-12 col-md-6 d-flex flex-column gap-3 justify-content-center align-content-center" style="padding-left: 10%; padding-right: 10%;">
				<div class="text-center">
					<img src="/assets/img/barangay-logo.png" alt="Barangay Logo" width="80" height="80">
					<h2 class="fw-bold text-primary">Barangay Portal</h2>
					<p class="text-muted mb-0">Sign in to continue</p>
				</div>

				<!-- Email -->
				<div class="form-floating">
					<input name="email" type="email" id="emailInput" class="form-control rounded-3" placeholder="Email" required>
					<label for="emailInput">Email</label>
				</div>

				<!-- Password -->
				<div class="form-floating">
					<input name="password" type="password" id="passwordInput" class="form-control rounded-3" placeholder="Password" required>
					<label for="passwordInput">Password</label>
				</div>

				<!-- Forgot Password -->
				<div class="text-end">
					<a href="#" class="text-decoration-none small text-primary">Forgot password?</a>
				</div>

				<!-- Error Message -->
				<div id="loginError" class="text-danger text-center small"></div>

				<!-- Submit -->
				<button type="submit" class="btn btn-primary w-100 fw-semibold rounded-3">
					Login
				</button>

				<!-- Register link -->
				<div class="text-center">
					<a class="link-primary text-decoration-none small" href="./registration.php">
						Don’t have an account? <strong>Register</strong>
					</a>
				</div>
			</form>

			<!-- Right: Illustration / Accent -->
			<div class="col-sm-12 col-md-6 bg-primary d-flex flex-column align-items-center justify-content-center text-white text-center p-5 position-relative">

				<!-- Soft gradient overlay -->
				<div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient"
					style="background: linear-gradient(135deg, rgba(0,0,0,0.2), rgba(255,255,255,0.1)); mix-blend-mode: overlay;">
				</div>

				<div class="position-relative z-2">
					<i class="bi bi-house-door-fill fs-1 mb-3 text-white"></i>
					<h2 class="fw-bold">Welcome to Barangay Portal</h2>
					<p class="text-white-50 small mb-4">Manage your documents and requests easily from home.</p>

					<div class="d-flex flex-column align-items-center gap-2 text-white-50 small">
						<div><i class="bi bi-file-earmark-text me-2 text-white"></i>Request Certificates Online</div>
						<div><i class="bi bi-person-badge me-2 text-white"></i>Access Resident Information</div>
						<div><i class="bi bi-chat-dots me-2 text-white"></i>Connect with Barangay Staff</div>
					</div>

					<div class="mt-4">
						<small class="text-white-50">Empowering our community through digital access.</small>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		const form = document.getElementById('loginForm');
		const errorDiv = document.getElementById('loginError');

		form.addEventListener('submit', (e) => {
			e.preventDefault();

			const formData = new FormData(form);
			const data = Object.fromEntries(formData.entries());

			axios.post('/api/login.php', data)
				.then(res => {
					if (res.data.status === 200) {
						document.cookie = `user_token=${res.data.token};path=/;max-age=${7*24*60*60}`;
						window.location.href = "/user";
					} else {
						errorDiv.textContent = res.data.message;
					}
				})
				.catch(() => {
					errorDiv.textContent = "An error occurred. Please try again.";
				});
		});
	</script>
</body>

</html>