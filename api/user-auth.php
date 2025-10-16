<?php

require __DIR__ . '/_config.php';
require __DIR__ . '/_functions.php';

blockBrowserAccess();

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

		// Check if email already exists
		$stmt = $conn->prepare("SELECT id FROM residents WHERE email = :email");
		$stmt->bindValue(':email', $email, SQLITE3_TEXT);
		$result = $stmt->execute();

		if ($result->fetchArray()) {
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
            (id, first_name, middle_name, last_name, email, password, birth_date, contact_number, gender, civil_status, address, token)
            VALUES (:id, :first_name, :middle_name, :last_name, :email, :password, :birth_date, :contact_number, :gender, :civil_status, :address, :token)
        ");

		$stmt->bindValue(':id', $id, SQLITE3_TEXT);
		$stmt->bindValue(':first_name', $first_name, SQLITE3_TEXT);
		$stmt->bindValue(':middle_name', $middle_name, SQLITE3_TEXT);
		$stmt->bindValue(':last_name', $last_name, SQLITE3_TEXT);
		$stmt->bindValue(':email', $email, SQLITE3_TEXT);
		$stmt->bindValue(':password', $hash_password, SQLITE3_TEXT);
		$stmt->bindValue(':birth_date', $birth_date, SQLITE3_TEXT);
		$stmt->bindValue(':contact_number', $contact_number, SQLITE3_TEXT);
		$stmt->bindValue(':gender', $gender, SQLITE3_TEXT);
		$stmt->bindValue(':civil_status', $civil_status, SQLITE3_TEXT);
		$stmt->bindValue(':address', $address, SQLITE3_TEXT);
		$stmt->bindValue(':token', $token, SQLITE3_TEXT);

		// Set cookie
		setcookie('user_token', $token, [
			'expires' => time() + (86400 * 7), // 1 week
			'path' => '/',
			'secure' => isset($_SERVER['HTTPS']),
			'httponly' => true,
			'samesite' => 'Strict',
		]);

		$result = $stmt->execute();

		if ($result) {
			setResult('Created Account Successfully', 201);
		} else {
			setResult('Failed to create account', 500);
		}
	},

	// Logout
	'delete' => function ($data) {
		global $conn;

		$token = $_COOKIE['user_token'] ?? null;

		if (!$token) {
			return setResult('No active session found', 400);
		}

		$stmt = $conn->prepare("UPDATE residents SET token = NULL WHERE token = :token");
		$stmt->bindValue(':token', $token, SQLITE3_TEXT);
		$result = $stmt->execute();

		// Expire cookie
		setcookie('user_token', '', [
			'expires' => time() - 3600,
			'path' => '/',
			'secure' => isset($_SERVER['HTTPS']),
			'httponly' => true,
			'samesite' => 'Strict',
		]);

		if ($conn->changes() > 0) {
			setResult('Logged out successfully', 200);
		} else {
			setResult('Invalid or expired token', 400);
		}
	}
]);
