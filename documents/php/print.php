<?php

require __DIR__ . '/../../vendor/autoload.php'; // Composer autoload
require __DIR__ . '/../../api/_config.php';
require __DIR__ . '/../../api/_functions.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Get environment variables
$barangayName = $_ENV['BARANGAY_NAME'];
$municipality = $_ENV['BARANGAY_MUNICIPALITY'];
$province = $_ENV['BARANGAY_PROVINCE'];
$captain = $_ENV['BARANGAY_CAPTAIN'];
$secretary = $_ENV['BARANGAY_SECRETARY'];

// Get request ID
$id = $_GET["id"] ?? null;

$request = $id ? getRequestById($id) : null;

// Determine if request is for self
$isSelf = ($request['request_for'] ?? 'Self') === 'Self';

// If self, get resident info
if ($isSelf && isset($request['resident_id'])) {
	$resident = getResidentById($request['resident_id']); // assuming you have this helper
	$full_name = $resident['first_name'] . " " . ($resident['middle_name'][0] ?? '') . '. ' . $resident['last_name'];
	$gender = $resident['gender'] ?? 'Male';
	$address = $resident['address'] ?? "Barangay $barangayName, $municipality, $province";
	$residency_start_date = $resident['residency_start_date'] ?? '0000-00-00';
} else {
	// Otherwise, use request info or defaults
	$full_name = $request
		? $request['first_name'] . " " . ($request['middle_name'][0] ?? '') . '. ' . $request['last_name']
		: 'JUAN DELA CRUZ';
	$gender = $request['gender'] ?? 'Male';
	$address = $request['address'] ?? "Barangay $barangayName, $municipality, $province";
	$residency_start_date = $request["residency_start_date"] ?? '0000-00-00';
}
