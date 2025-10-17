<?php
require __DIR__ . '/_config.php';
require __DIR__ . '/_functions.php';

blockBrowserAccess();

try {
	handle([
		// Create Account
		'post' => function ($data) {
			global $conn;

			$first_name       = $data['first_name'];
			$middle_name      = $data['middle_name'];
			$last_name        = $data['last_name'];
			$email            = $data['email'];
			$password         = $data['password'];
			$confirm_password = $data['confirm_password'];
			$birth_date       = $data['birth_date'];
			$contact_number   = $data['contact_number'];
			$gender           = $data['gender'];
			$civil_status     = $data['civil_status'];
			$address          = $data['address'];
			$residency_start_date = $data['residency_start_date'] ?? null;

			// Check if email already exists
			$stmt = $conn->prepare("SELECT id FROM residents WHERE email = ?");
			$stmt->bind_param("s", $email);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				return setResult('Email is already in use', 400);
			}

			if ($password !== $confirm_password) {
				return setResult('Password and Confirm Password do not match', 400);
			}

			$id = uniqid('user_');
			$token = generateToken();
			$hash_password = password_hash($password, PASSWORD_DEFAULT);

			$stmt = $conn->prepare("
				INSERT INTO residents 
				(id, first_name, middle_name, last_name, email, password, birth_date, contact_number, gender, civil_status, address, token, residency_start_date)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
			");

			$stmt->bind_param(
				"sssssssssssss",
				$id,
				$first_name,
				$middle_name,
				$last_name,
				$email,
				$hash_password,
				$birth_date,
				$contact_number,
				$gender,
				$civil_status,
				$address,
				$token,
				$residency_start_date
			);

			setcookie('user_token', $token, [
				'expires' => time() + (86400 * 7), // 1 week
				'path' => '/',
				'secure' => isset($_SERVER['HTTPS']),
				'httponly' => true,
				'samesite' => 'Strict',
			]);

			if ($stmt->execute()) {
				setResult('Created Account Successfully', 201);
			} else {
				setResult('Failed to create account: ' . $stmt->error, 500);
			}
		},

		// Logout
		'delete' => function ($data) {
			global $conn;

			$token = $_COOKIE['user_token'] ?? null;

			if (!$token) {
				return setResult('No active session found', 400);
			}

			$stmt = $conn->prepare("UPDATE residents SET token = NULL WHERE token = ?");
			$stmt->bind_param("s", $token);
			$stmt->execute();

			setcookie('user_token', '', [
				'expires' => time() - 3600,
				'path' => '/',
				'secure' => isset($_SERVER['HTTPS']),
				'httponly' => true,
				'samesite' => 'Strict',
			]);

			if ($stmt->affected_rows > 0) {
				setResult('Logged out successfully', 200);
			} else {
				setResult('Invalid or expired token', 400);
			}
		}
	]);
} catch (Exception $e) {
	setResult($e->getMessage(), $e->getCode());
}
