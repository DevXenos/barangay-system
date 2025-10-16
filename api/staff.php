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
            VALUES (:id, :first_name, :last_name, :email, :phone_number, :role, :password)
        ");

		$stmt->bindValue(':id', $id, SQLITE3_TEXT);
		$stmt->bindValue(':first_name', $data['first_name'], SQLITE3_TEXT);
		$stmt->bindValue(':last_name', $data['last_name'], SQLITE3_TEXT);
		$stmt->bindValue(':email', $data['email'], SQLITE3_TEXT);
		$stmt->bindValue(':phone_number', $data['phone_number'], SQLITE3_TEXT);
		$stmt->bindValue(':role', $data['role'], SQLITE3_TEXT);
		$stmt->bindValue(':password', $hashedPassword, SQLITE3_TEXT);

		$result = $stmt->execute();

		if ($result) {
			setResult('Staff created successfully', 201);
		} else {
			setResult('Failed to create staff', 500);
		}
	},

	'delete' => function ($data) {
		global $conn;

		$id = $data['id'] ?? null;

		if (!$id) {
			setResult('Staff ID is required', 400);
		}

		$stmt = $conn->prepare("DELETE FROM staffs WHERE id = :id");
		$stmt->bindValue(':id', $id, SQLITE3_TEXT);
		$result = $stmt->execute();

		if ($result && $conn->changes() > 0) {
			setResult('Staff deleted successfully', 200);
		} elseif ($result) {
			setResult('Staff not found', 404);
		} else {
			setResult('Failed to delete staff', 500);
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
                SET first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number, role = :role, password = :password
                WHERE id = :id
            ");
			$stmt->bindValue(':password', $hashedPassword, SQLITE3_TEXT);
		} else {
			$stmt = $conn->prepare("
                UPDATE staffs 
                SET first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number, role = :role
                WHERE id = :id
            ");
		}

		$stmt->bindValue(':first_name', $firstName, SQLITE3_TEXT);
		$stmt->bindValue(':last_name', $lastName, SQLITE3_TEXT);
		$stmt->bindValue(':email', $email, SQLITE3_TEXT);
		$stmt->bindValue(':phone_number', $phoneNumber, SQLITE3_TEXT);
		$stmt->bindValue(':role', $role, SQLITE3_TEXT);
		$stmt->bindValue(':id', $id, SQLITE3_TEXT);

		$result = $stmt->execute();

		if ($result && $conn->changes() > 0) {
			setResult('Staff updated successfully', 200);
		} elseif ($result) {
			setResult('No changes made or staff not found', 404);
		} else {
			setResult('Failed to update staff', 500);
		}
	}
]);
