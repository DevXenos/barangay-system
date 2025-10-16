<?php

function generateID()
{
	return uniqid('u');
}

function generateToken()
{
	return bin2hex(random_bytes(16)); // 32-character token
}

function cleanData($data)
{
	if (is_array($data)) {
		$clean = [];
		foreach ($data as $key => $value) {
			$clean[$key] = cleanData($value);
		}
		return $clean;
	} else {
		return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
	}
}

function getData(): array
{
	header('Content-Type: application/json');

	static $cached;
	if ($cached !== null) return $cached;

	$data = [];

	if (!empty($_POST)) {
		$data = $_POST;
	} else {
		$input = file_get_contents('php://input');
		if ($input) {
			$decoded = json_decode($input, true);
			if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
				$data = $decoded;
			} else {
				parse_str($input, $data);
			}
		}
	}

	$cleaned = cleanData($data ?? []);

	if (empty($cleaned['action'])) {
		$cleaned['action'] = 'post';
	}

	$cached = $cleaned;
	return $cleaned;
}

function blockBrowserAccess()
{
	$accept = $_SERVER['HTTP_ACCEPT'] ?? '';
	if (strpos($accept, 'text/html') !== false) {
		http_response_code(405);
		include __DIR__ . '/../pages/block.html';
		exit;
	}
}

function getMethod()
{
	return $_SERVER['REQUEST_METHOD'] ?? 'GET';
}

function getUser($id)
{
	global $conn;

	$stmt = $conn->prepare('SELECT id, username, email FROM users WHERE id = :id');
	$stmt->bindValue(':id', $id, SQLITE3_TEXT);
	$result = $stmt->execute();

	$row = $result->fetchArray(SQLITE3_ASSOC);
	return $row ?: null;
}

function setResult($message, $status = 200, $data = [])
{
	$result = [
		'message' => $message,
		'status' => $status,
	];

	if (!empty($data)) {
		$result['data'] = $data;
	}

	header('Content-Type: application/json');
	echo json_encode($result);
	exit;
}

function handle(array $actions)
{
	$data = getData();
	$actionKey = strtolower(trim($data['action'] ?? ''));

	if (isset($actions[$actionKey])) {
		return $actions[$actionKey]($data);
	}

	echo json_encode([
		'status' => 400,
		'message' => "Unknown or missing action",
		'available_actions' => array_keys($actions),
	]);
}

function getDocumentName($id = "")
{
	$docs = [
		"barangay_clearance" => "Barangay Clearance",
		"certificate_of_indigency" => "Certificate of Indigency",
		"certificate_of_residency" => "Certificate of Residency",
	];

	if ($id && isset($docs[$id])) {
		return $docs[$id];
	}

	return $docs;
}

function getBadgeClass($class_name = '')
{
	$badge_classes = [
		'Pending' => 'bg-warning text-dark',
		'Approved' => 'bg-success',
		'Rejected' => 'bg-danger',
		'Cancelled' => 'bg-secondary',
	];

	if ($class_name && isset($badge_classes[$class_name])) {
		return $badge_classes[$class_name];
	}

	return 'bg-dark';
}

function getRequestByResidentsId($id)
{
	global $conn;

	$stmt = $conn->prepare("SELECT * FROM requests WHERE resident_id = :id ORDER BY created_at DESC");
	$stmt->bindValue(':id', $id, SQLITE3_TEXT);
	$result = $stmt->execute();

	$data = [];
	while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
		$data[] = $row;
	}

	return $data;
}

function getAllRequests()
{
	global $conn;

	$result = $conn->query("SELECT * FROM requests ORDER BY created_at DESC");

	$data = [];
	while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
		$data[] = $row;
	}

	return $data;
}

function getAnnouncements()
{
	global $conn;

	$result = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");

	$data = [];
	while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
		$data[] = $row;
	}

	return $data;
}
