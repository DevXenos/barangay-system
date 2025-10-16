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

		$resident_id   = $data['resident_id'];
		$request_for   = $data['request_for'];
		$document_type = $data['document_type'];
		$first_name    = $data['first_name'];
		$middle_name   = $data['middle_name'];
		$last_name     = $data['last_name'];
		$birth_date    = $data['birth_date'];
		$gender        = $data['gender'];
		$civil_status  = $data['civil_status'];
		$address       = $data['address'];
		$contact_number = $data['contact_number'];
		$purpose       = $data['purpose'];

		$id = generateRequestId();

		$stmt = $conn->prepare("
            INSERT INTO requests (
                id, request_for, resident_id, document_type, first_name, middle_name, last_name, birth_date, gender, civil_status, address, contact_number, purpose
            ) VALUES (
                :id, :request_for, :resident_id, :document_type, :first_name, :middle_name, :last_name, :birth_date, :gender, :civil_status, :address, :contact_number, :purpose
            )
        ");

		$stmt->bindValue(':id', $id, SQLITE3_TEXT);
		$stmt->bindValue(':request_for', $request_for, SQLITE3_TEXT);
		$stmt->bindValue(':resident_id', $resident_id, SQLITE3_TEXT);
		$stmt->bindValue(':document_type', $document_type, SQLITE3_TEXT);
		$stmt->bindValue(':first_name', $first_name, SQLITE3_TEXT);
		$stmt->bindValue(':middle_name', $middle_name, SQLITE3_TEXT);
		$stmt->bindValue(':last_name', $last_name, SQLITE3_TEXT);
		$stmt->bindValue(':birth_date', $birth_date, SQLITE3_TEXT);
		$stmt->bindValue(':gender', $gender, SQLITE3_TEXT);
		$stmt->bindValue(':civil_status', $civil_status, SQLITE3_TEXT);
		$stmt->bindValue(':address', $address, SQLITE3_TEXT);
		$stmt->bindValue(':contact_number', $contact_number, SQLITE3_TEXT);
		$stmt->bindValue(':purpose', $purpose, SQLITE3_TEXT);

		$result = $stmt->execute();

		if ($result) {
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

		$stmt = $conn->prepare("UPDATE requests SET status = :status WHERE id = :id");
		$stmt->bindValue(':status', $status, SQLITE3_TEXT);
		$stmt->bindValue(':id', $id, SQLITE3_TEXT);

		$result = $stmt->execute();

		if ($result && $conn->changes() > 0) {
			setResult("Request status updated to {$status}.", 200);
		} elseif ($result) {
			setResult('No matching request found.', 404);
		} else {
			setResult('Failed to update request status. Please try again later.', 500);
		}
	},
]);
