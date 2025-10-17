<?php
require __DIR__ . '/_config.php';
require __DIR__ . '/_functions.php';

blockBrowserAccess();

handle([
	'post' => function ($data) {
		global $conn;

		$password = $data['password'] ?? '';

		// Generate unique ID
		$id = uniqid('staff_');

		// Hash the password
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

		// Prepare insert statement
		$stmt = $conn->prepare("
			INSERT INTO staffs 
			(id, first_name, last_name, email, phone_number, role, password)
			VALUES (?, ?, ?, ?, ?, ?, ?)
		");

		$stmt->bind_param(
			"sssssss",
			$id,
			$data['first_name'],
			$data['last_name'],
			$data['email'],
			$data['phone_number'],
			$data['role'],
			$hashedPassword
		);

		if ($stmt->execute()) {
			setResult('Staff created successfully', 201);
		} else {
			setResult('Failed to create staff: ' . $stmt->error, 500);
		}
	},

	'delete' => function ($data) {
		global $conn;

		$id = $data['id'] ?? null;

		if (!$id) {
			setResult('Staff ID is required', 400);
		}

		$stmt = $conn->prepare("DELETE FROM staffs WHERE id = ?");
		$stmt->bind_param("s", $id);
		$stmt->execute();

		if ($stmt->affected_rows > 0) {
			setResult('Staff deleted successfully', 200);
		} else {
			setResult('Staff not found or failed to delete', 404);
		}
	},

	'put' => function ($data) {
		global $conn;

		$id = $data['id'] ?? null;
		if (!$id) {
			setResult('Staff ID is required', 400);
		}

		$firstName   = $data['first_name'] ?? '';
		$lastName    = $data['last_name'] ?? '';
		$email       = $data['email'] ?? '';
		$phoneNumber = $data['phone_number'] ?? '';
		$role        = $data['role'] ?? '';
		$password    = $data['password'] ?? null;

		if (!$firstName || !$lastName || !$email || !$role) {
			setResult('Required fields are missing', 400);
		}

		if ($password) {
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $conn->prepare("
				UPDATE staffs 
				SET first_name = ?, last_name = ?, email = ?, phone_number = ?, role = ?, password = ?
				WHERE id = ?
			");
			$stmt->bind_param(
				"sssssss",
				$firstName,
				$lastName,
				$email,
				$phoneNumber,
				$role,
				$hashedPassword,
				$id
			);
		} else {
			$stmt = $conn->prepare("
				UPDATE staffs 
				SET first_name = ?, last_name = ?, email = ?, phone_number = ?, role = ?
				WHERE id = ?
			");
			$stmt->bind_param(
				"ssssss",
				$firstName,
				$lastName,
				$email,
				$phoneNumber,
				$role,
				$id
			);
		}

		$stmt->execute();

		if ($stmt->affected_rows > 0) {
			setResult('Staff updated successfully', 200);
		} else {
			setResult('No changes made or staff not found', 404);
		}
	}
]);
