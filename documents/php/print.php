<?php

require __DIR__ . '/../../api/_config.php';
require __DIR__ . '/../../api/_functions.php';

// --- Barangay Information (from your provided .env values) ---
$barangayName = "Don Pedro";
$municipality = "Mansalay";
$province = "Oriental Mindoro";

$captain = "Danielle Nixon";
$secretary = "Lois Vasquez";
// --------------------------------------------------------------

// Get request ID
$id = $_GET["id"] ?? null;

// Fetch the request
$request = $id ? getRequestById($id) : null;

// Determine if request is for self
$isSelf = ($request['request_for'] ?? 'Self') === 'Self';

// If self, get resident info
if ($isSelf && isset($request['resident_id'])) {
	$resident = getResidentById($request['resident_id']); // helper function
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
