<?php
// inc/user-header.php

$user = $user ?? ['fullName' => 'Resident'];

// Define menu items
$menuItems = [
	['label' => 'Home', 'href' => '/user', 'icon' => 'bi bi-house'],
	['label' => 'My Requests', 'href' => '/user/my-requests', 'icon' => 'bi bi-card-list'],
	['label' => 'Announcements', 'href' => '/user/announcements', 'icon' => 'bi bi-megaphone'],
	['label' => 'Profile', 'href' => '/user/profile', 'icon' => 'bi bi-person-gear']
];

?>

<nav class="navbar navbar-expand-lg bg-light shadow-sm p-3 position-sticky top-0" style="z-index: 100;">
	<div class="container container-sm">
		<div class="d-flex align-items-center gap-2">
			<?php if ($_SERVER['REQUEST_URI'] !== '/user'): ?>
				<button 
					onclick="window.history.back()"
					class="btn"
					style="position: absolute; transform: translateX(-110%); aspect-ratio: 1/1;"
					>
					<i style="font-size: 25px;" class="bi bi-arrow-left"></i>
				</button>
			<?php endif; ?>
			<a class="navbar-brand fw-bold" href="/user"><?= htmlspecialchars($header ?? 'Dashboard') ?></a>
		</div>

		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#userNavbar" aria-controls="userNavbar" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="userNavbar">
			<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
				<?php
				// Loop through menu items
				foreach ($menuItems as $item):
					// Highlight active page
					$activeClass = ($_SERVER['REQUEST_URI'] === $item['href']) ? 'active fw-bold' : '';
				?>
					<li class="nav-item">
						<a class="nav-link <?= $activeClass ?> d-flex align-items-center" href="<?= $item['href'] ?>">
							<i class="<?= $item['icon'] ?> me-1"></i>
							<?= htmlspecialchars($item['label']) ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</nav>