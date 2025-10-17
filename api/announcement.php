<?php
require __DIR__ . '/_config.php';
require __DIR__ . '/_functions.php';

blockBrowserAccess();

handle([
	'post' => function ($data) {
		global $conn;

		$date        = $data['date'] ?? null;
		$description = $data['description'] ?? null;
		$title       = $data['title'] ?? null;
		$time        = $data['time'] ?? "00:00"; // Means whole day

		if (!$date || !$description || !$title) {
			setResult('Title, description, and date are required', 400);
		}

		$id = uniqid('announcement_');

		$stmt = $conn->prepare("
			INSERT INTO announcements (id, title, description, date, time)
			VALUES (?, ?, ?, ?, ?)
		");
		$stmt->bind_param("sssss", $id, $title, $description, $date, $time);

		if ($stmt->execute()) {
			setResult('Announcement uploaded successfully', 201);
		} else {
			setResult('Failed to create announcement', 500);
		}
	}
]);
