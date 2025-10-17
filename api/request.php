<?php
require __DIR__ . '/_config.php';
require __DIR__ . '/_functions.php';

blockBrowserAccess();

function generateRequestId()
{
	$time = time(); // seconds since epoch
	$rand = mt_rand(1000, 9999);
	return "request_{$time}{$rand}";
}

handle([
	'post' => function ($data) {
		global $conn;

		$resident_id    = $data['resident_id'];
		$request_for    = $data['request_for'];
		$document_type  = $data['document_type'];
		$first_name     = $data['first_name'];
		$middle_name    = $data['middle_name'];
		$last_name      = $data['last_name'];
		$birth_date     = $data['birth_date'];
		$gender         = $data['gender'];
		$civil_status   = $data['civil_status'];
		$address        = $data['address'];
		$contact_number = $data['contact_number'];
		$purpose        = $data['purpose'];

		$id = generateRequestId();

		$stmt = $conn->prepare("
			INSERT INTO requests (
				id, request_for, resident_id, document_type, first_name, middle_name, last_name, birth_date, gender, civil_status, address, contact_number, purpose
			) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
		");

		$stmt->bind_param(
			"sssssssssssss",
			$id,
			$request_for,
			$resident_id,
			$document_type,
			$first_name,
			$middle_name,
			$last_name,
			$birth_date,
			$gender,
			$civil_status,
			$address,
			$contact_number,
			$purpose
		);

		if ($stmt->execute()) {
			setResult("Your document request has been submitted successfully.", 201);
		} else {
			setResult("Failed to submit document request. Please try again later.", 500);
		}
	},

	'put' => function ($data) {
		global $conn;

		$id     = $data['id'] ?? null;
		$status = $data['status'] ?? null;

		if (!$id) {
			setResult('Request ID is required.', 400);
		}

		if (!$status) {
			setResult('Status is not set. Please provide Approved / Rejected / Cancelled.', 400);
		}

		$stmt = $conn->prepare("UPDATE requests SET status = ? WHERE id = ?");
		$stmt->bind_param("ss", $status, $id);
		$stmt->execute();

		if ($stmt->affected_rows > 0) {
			setResult("Request status updated to {$status}.", 200);
		} else {
			setResult('No matching request found or no changes made.', 404);
		}
	},

	// Cancel (currently empty)
	"delete" => function ($data) {
		global $conn;
		// You can implement cancel/delete logic here later
	}
]);
