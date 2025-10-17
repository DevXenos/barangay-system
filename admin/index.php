<?php
require __DIR__ . '/../api/_config.php';
require __DIR__ . '/../api/_functions.php';

$title = "Admin Login";
include './../inc/lib.php'; // Header

$show_login = true;
$admin = null;

$token = $_COOKIE['token'] ?? "";

// --- Check token ---
if ($token) {
	$stmt = $conn->prepare("SELECT id, first_name, last_name, email, phone_number, role FROM staffs WHERE token = ?");
	$stmt->bind_param("s", $token);
	$stmt->execute();
	$result = $stmt->get_result();
	$admin = $result->fetch_assoc();

	if ($admin) {
		$show_login = false;
		$title = "Dashboard";
	} else {
		setcookie('token', '', time() - 3600, '/');
	}
}

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = rtrim($path, '/');
if ($path === '') $path = '/';

if ($show_login && $path !== '/admin') {
	header('Location: /admin');
	exit;
}

if ($show_login && $path === '/admin') {
	include __DIR__ . '/login.php';
	exit;
}

// ---------------- FUNCTIONS ---------------- //
function getAllAnnouncement()
{
	global $conn;
	$data = [];
	$stmt = $conn->prepare('SELECT * FROM announcements ORDER BY `date` DESC');
	if ($stmt) {
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
	}
	return $data;
}

function getAllStaffs()
{
	global $conn;
	$data = [];
	$result = $conn->query("SELECT * FROM `staffs` ORDER BY `created_at` DESC");
	while ($row = $result->fetch_assoc()) {
		$data[] = $row;
	}
	return $data;
}
?>

<body class="d-flex p-3 gap-3 overflow-hidden" style="height: 100svh;">
	<!-- Sidebar -->
	<aside class="sidebar overflow-auto" style="width: 230px; max-width: 230px; width: 100%; height: 100%;">
		<div class="mb-4">
			<h5>Barangay Admin</h5>
			<small class="text-muted d-block"><?= htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name']) ?></small>
			<span class="badge bg-primary-subtle text-primary mt-1"><?= ucfirst($admin['role']) ?></span>
		</div>

		<nav class="nav d-flex flex-column flex-fill gap-1">
			<a href="/admin" class="nav-link <?= $path === '/admin' ? 'active' : '' ?>">🏠 Dashboard</a>
			<a href="/admin/residents" class="nav-link <?= str_starts_with($path, '/admin/residents') ? 'active' : '' ?>">👥 Residents</a>
			<a href="/admin/staff" class="nav-link <?= $path === '/admin/staff' ? 'active' : '' ?>">🧑‍💼 Staff</a>
			<a href="/admin/requests" class="nav-link <?= $path === '/admin/requests' ? 'active' : '' ?>">🧾 Requests</a>
			<a href="/admin/reports" class="nav-link <?= $path === '/admin/reports' ? 'active' : '' ?>">📊 Reports</a>
			<a href="/admin/settings" class="nav-link <?= $path === '/admin/settings' ? 'active' : '' ?>">⚙️ Settings</a>

			<hr class="mt-auto">
			<button id="logoutBtn" class="nav-link text-danger fw-semibold">🚪 Logout</button>
		</nav>
	</aside>

	<!-- Main -->
	<main class="flex-fill bg-transparent d-flex flex-column" style="overflow: auto;">
		<?php
		include __DIR__ . '/../dialogs/confirmation-dialog.php';

		// Detect resident profile if profile_id exists
		$profileId = $_GET['profile_id'] ?? null;

		// Default routes
		$routes = [
			'/admin' => './home.php',
			'/admin/residents' => $profileId ? './residents-profile.php' : './residents.php',
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
	// JS / Dialogs per page
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

		case '/admin/residents':
			if ($profileId) {
				echo '<script type="module" src="./../dist/admin/residents-profile.js"></script>';
			} else {
				echo '<script type="module" src="./../dist/admin/residents.js"></script>';
			}
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
	}

	.sidebar .nav-link.active {
		background-color: #e7f1ff;
		color: #0d6efd;
		font-weight: 600;
		border-left: 4px solid #0d6efd;
		padding-left: 8px;
	}

	.sidebar .nav-link.active:hover {
		background-color: #d0e4ff;
	}

	.sidebar .nav-link.text-danger {
		cursor: pointer;
	}
</style>