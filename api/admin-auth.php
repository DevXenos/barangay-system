<?php
require __DIR__ . '/_config.php';
require __DIR__ . '/_functions.php';

blockBrowserAccess();

handle([
	// ------------------------------
	// Login action
	// ------------------------------
	'get' => function ($data) {
		global $conn;

		$email = $data['email'] ?? '';
		$password = $data['password'] ?? '';

		if (!$email || !$password) {
			setResult('Email and password are required', 400);
		}

		// Fetch staff/admin
		$stmt = $conn->prepare("SELECT id, first_name, last_name, email, password, role FROM staffs WHERE email = :email");
		$stmt->bindValue(':email', $email, SQLITE3_TEXT);
		$result = $stmt->execute();
		$staff = $result->fetchArray(SQLITE3_ASSOC);

		if (!$staff) {
			setResult('Staff not found', 404);
		}

		// Verify password
		if (!password_verify($password, $staff['password'])) {
			setResult('Incorrect password', 401);
		}

		// Generate a token
		$token = bin2hex(random_bytes(16)); // 32 characters
		setcookie('token', $token, [
			'expires' => time() + 86400, // 24 hours
			'path' => '/',
			'secure' => isset($_SERVER['HTTPS']),
			'httponly' => true,
			'samesite' => 'Strict',
		]);

		// Save token in database
		$stmt = $conn->prepare("UPDATE staffs SET token = :token WHERE id = :id");
		$stmt->bindValue(':token', $token, SQLITE3_TEXT);
		$stmt->bindValue(':id', $staff['id'], SQLITE3_TEXT);
		$stmt->execute();

		setResult('Login successful', 200, [
			'id' => $staff['id'],
			'first_name' => $staff['first_name'],
			'last_name' => $staff['last_name'],
			'email' => $staff['email'],
			'role' => $staff['role'],
		]);
	},

	// ------------------------------
	// Delete action / Logout
	// ------------------------------
	'delete' => function ($data) {
		global $conn;

		$token = $_COOKIE['token'] ?? "";

		if (!$token) {
			setResult('No active session', 400);
		}

		// Clear the token in the database
		$stmt = $conn->prepare("UPDATE staffs SET token = NULL WHERE token = :token");
		$stmt->bindValue(':token', $token, SQLITE3_TEXT);
		$stmt->execute();

		// Delete the cookie
		setcookie('token', '', [
			'expires' => time() - 3600, // past time to delete
			'path' => '/',
			'secure' => isset($_SERVER['HTTPS']),
			'httponly' => true,
			'samesite' => 'Strict',
		]);

		setResult('Logged out successfully', 200);
	},

	// ------------------------------
	// Update Password
	// ------------------------------
	'put' => function ($data) {
		global $conn;

		$old_password = $data['old_password'] ?? '';
		$new_password = $data['new_password'] ?? '';

		if (!$old_password || !$new_password) {
			return setResult('Old and new passwords are required', 400);
		}

		$token = $_COOKIE['token'] ?? '';

		if (!$token) {
			return setResult('No active session', 400);
		}

		// Get current hashed password from DB based on token
		$stmt = $conn->prepare("SELECT id, password FROM staffs WHERE token = :token");
		$stmt->bindValue(':token', $token, SQLITE3_TEXT);
		$result = $stmt->execute();
		$admin = $result->fetchArray(SQLITE3_ASSOC);

		if (!$admin) {
			return setResult('Admin not found', 404);
		}

		// Verify old password
		if (!password_verify($old_password, $admin['password'])) {
			return setResult('Current password is incorrect', 401);
		}

		// Check if new password is same as old
		if (password_verify($new_password, $admin['password'])) {
			return setResult('New password cannot be the same as the current password', 400);
		}

		// Hash the new password
		$hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

		// Update the password in DB
		$update = $conn->prepare("UPDATE staffs SET password = :password WHERE id = :id");
		$update->bindValue(':password', $hashed_new_password, SQLITE3_TEXT);
		$update->bindValue(':id', $admin['id'], SQLITE3_TEXT);

		if ($update->execute()) {
			setResult('Password updated successfully', 200);
		} else {
			setResult('Failed to update password', 500);
		}
	}
]);
