<?php

require __DIR__ . '/../api/_config.php';
require __DIR__ . '/../api/_functions.php';

include './../inc/lib.php';

// Get user token
$token = $_COOKIE['user_token'] ?? null;

if (!$token) {
	header("Location: /");
	exit;
} else {
	$stmt = $conn->prepare('SELECT * FROM residents WHERE token = :token');
	$stmt->bindValue(':token', $token, SQLITE3_TEXT);
	$result = $stmt->execute();

	$user = $result ? $result->fetchArray(SQLITE3_ASSOC) : false;

	if (!$user) {
		setcookie('user_token', '', time() - 3600, '/');
		header("Location: /");
		exit;
	}
}

// Get path without query
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Normalize path → remove trailing slashes except root
$path = rtrim($path, '/');
if ($path === '') $path = '/';

// Routes
$routes = [
	'/user' => './home.php',
	'/user/my-requests' => './my-requests.php',
	'/user/profile' => './profile.php',
	'/user/announcements' => './announcements.php',
	'/user/request-document' => './request-document.php'
];

?>

<body class="bg-light d-flex flex-column min-vh-100">
	<?php include './../inc/user-header.php'; ?>

	<div class="flex-fill container container-lg d-flex flex-column gap-3 pt-3 pb-3">
		<?php
		if (isset($routes[$path])) {
			include $routes[$path];
		} else {
			include './not-found.php';
		}
		?>
	</div>

	<?php include __DIR__ . '/../dialogs/confirmation-dialog.php' ?>
</body>