<?php
require __DIR__ . '/../api/_config.php';
require __DIR__ . '/../api/_functions.php';

$title = "Admin Login"; // default
include './../inc/lib.php'; // Header

$show_login = true; // show login by default
$admin = null;

$token = $_COOKIE['token'] ?? "";

// Check token if exists
if ($token) {
	$stmt = $conn->prepare("SELECT id, first_name, last_name, email, phone_number, role FROM staffs WHERE token = :token");
	$stmt->bindValue(':token', $token, SQLITE3_TEXT);
	$result = $stmt->execute();
	$admin = $result->fetchArray(SQLITE3_ASSOC);

	if ($admin) {
		$show_login = false;
		$title = "Dashboard";
	} else {
		// Invalid token → delete cookie
		setcookie('token', '', time() - 3600, '/');
	}
}

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = rtrim($path, '/');
if ($path === '') $path = '/';

if ($show_login && $path !== '/admin') {
	// Make sure is always on admin
	header('Location: /admin');
	exit;
}

if ($show_login && $path === '/admin') {
	// If no token then path is on admin then show login.php
	include __DIR__ . '/login.php';
	exit;
}

// At this point, $admin is valid

// Declare all functions
function getAllAnnouncement()
{
	global $conn;

	$stmt = $conn->prepare('SELECT * FROM announcements ORDER BY `date` DESC');
	if ($stmt) {
		$result = $stmt->execute();
		$data = [];
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	return [];
}

function getAllStaffs()
{
	global $conn;

	$result = $conn->query("SELECT * FROM `staffs` ORDER BY `created_at` DESC");
	$data = [];
	while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
		$data[] = $row;
	}
	return $data;
}

function getAllResidents()
{
	global $conn;

	$result = $conn->query("SELECT * FROM `residents` ORDER BY `created_at` DESC");
	$data = [];
	while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
		$data[] = $row;
	}
	return $data;
}
?>

<body class="d-flex p-3 gap-3 overflow-hidden" style="height: 100svh;">
	<!-- Sidebar and Main content below -->
	<aside class="sidebar overflow-auto" style="width: 230px; max-width: 230px; width: 100%; height: 100%;">
		<div class="mb-4">
			<h5>Barangay Admin</h5>
			<small class="text-muted d-block"><?= htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name']) ?></small>
			<span class="badge bg-primary-subtle text-primary mt-1"><?= ucfirst($admin['role']) ?></span>
		</div>

		<nav class="nav d-flex flex-column flex-fill gap-1">
			<a href="/admin" class="nav-link <?= $path === '/admin' ? 'active' : '' ?>">🏠 Dashboard</a>
			<a href="/admin/residents" class="nav-link <?= $path === '/admin/residents' ? 'active' : '' ?>">👥 Residents</a>
			<a href="/admin/staff" class="nav-link <?= $path === '/admin/staff' ? 'active' : '' ?>">🧑‍💼 Staff</a>
			<a href="/admin/requests" class="nav-link <?= $path === '/admin/requests' ? 'active' : '' ?>">🧾 Requests</a>
			<a href="/admin/reports" class="nav-link <?= $path === '/admin/reports' ? 'active' : '' ?>">📊 Reports</a>
			<a href="/admin/settings" class="nav-link <?= $path === '/admin/settings' ? 'active' : '' ?>">⚙️ Settings</a>

			<hr class="mt-auto">
			<button id="logoutBtn" class="nav-link text-danger fw-semibold">🚪 Logout</button>
		</nav>
	</aside>

	<main class="flex-fill bg-transparent d-flex flex-column" style="overflow: auto;">
		<?php
		include __DIR__ . '/../dialogs/confirmation-dialog.php';

		$routes = [
			'/admin' => './home.php',
			'/admin/residents' => './residents.php',
			'/admin/staff' => './staff.php',
			'/admin/requests' => './requests.php',
			'/admin/reports' => './reports.php',
			'/admin/settings' => './settings.php'
		];

		if (isset($routes[$path])) {
			include $routes[$path];
		} else {
			include __DIR__ . '/../inc/not-found.php';
		}
		?>
	</main>

	<?php
	switch ($path) {
		case '/admin':
			include __DIR__ . '/../dialogs/add-new-announcement.php';
			echo '<script type="module" src="./../dist/admin/overview.js"></script>';
			break;

		case '/admin/staff':
			include __DIR__ . '/../dialogs/add-new-staff.php';
			echo '<script type="module" src="./../dist/admin/staff.js"></script>';
			break;
		case '/admin/settings':
			echo '<script type="module" src="./../dist/admin/settings.js"></script>';
			break;
	}
	?>
	<script type="module" src="./../dist/admin/index.js"></script>
</body>

<style>
	.sidebar .nav-link {
		border-radius: 8px;
		padding: 10px 12px;
		font-weight: 500;
		display: flex;
		align-items: center;
		gap: 8px;
		transition: all 0.2s ease;
		color: #333;
		text-decoration: none;
	}

	.sidebar .nav-link:hover {
		background-color: #f0f6ff;
		color: #0d6efd;
		text-decoration: none;
	}

	/* Highlight selected link */
	.sidebar .nav-link.active {
		background-color: #e7f1ff;
		color: #0d6efd;
		font-weight: 600;
		border-left: 4px solid #0d6efd;
		padding-left: 8px;
		/* adjust so border doesn't shift content */
	}

	.sidebar .nav-link.active:hover {
		background-color: #d0e4ff;
		/* slightly stronger on hover */
	}

	/* Logout button */
	.sidebar .nav-link.text-danger {
		cursor: pointer;
	}
</style>