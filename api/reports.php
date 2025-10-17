<?php
require __DIR__ . '/_config.php';
require __DIR__ . '/_functions.php';

blockBrowserAccess();

handle([
	"post" => function ($data) {
		global $conn;

		$id = uniqid("report_");
		$request_id = $data['request_id'];
		$status = $data['status'];
		$process_by = $data['process_by'];

		$stmt = $conn->prepare("
			INSERT INTO reports (id, request_id, status, process_by)
			VALUES (?, ?, ?, ?)
		");
		$stmt->bind_param("ssss", $id, $request_id, $status, $process_by);

		if ($stmt->execute()) {
			setResult("Report created successfully", 201);
		} else {
			setResult("Report failed to create!", 500);
		}
	},

	// Update to paid
	"put" => function ($data) {
		global $conn;

		$id = $data['report_id'] ?? null; // report ID

		if (!$id) {
			setResult("Report ID is required", 400);
		}

		$stmt = $conn->prepare("
			UPDATE reports
			SET status = 'Paid', updated_at = CURRENT_TIMESTAMP
			WHERE id = ?
		");
		$stmt->bind_param("s", $id);
		$stmt->execute();

		if ($stmt->affected_rows > 0) {
			setResult("Report marked as Paid successfully", 200);
		} else {
			setResult("No changes made or report not found", 404);
		}
	},
]);
