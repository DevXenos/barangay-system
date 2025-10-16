<!-- /user/home.php -->
<div class="user-home container py-4">

	<!-- Welcome Section -->
	<div class="welcome-section text-center mb-4">
		<h3 class="fw-bold mb-1">Welcome, <?= htmlspecialchars($user['first_name']) ?>!</h3>
		<p class="text-muted mb-0">Manage your barangay document requests easily.</p>
	</div>

	<!-- Quick Actions -->
	<div class="quick-actions row g-3 mb-4">
		<div class="col-12 col-md-4">
			<a href="/user/request-document" class="card action-card shadow-sm p-4 text-center text-decoration-none h-100">
				<div class="fs-1 mb-2">📝</div>
				<div class="fw-semibold">Request a Document</div>
				<small class="text-muted d-block">Start a new request</small>
			</a>
		</div>
		<div class="col-12 col-md-4">
			<a href="/user/my-requests" class="card action-card shadow-sm p-4 text-center text-decoration-none h-100">
				<div class="fs-1 mb-2">📂</div>
				<div class="fw-semibold">My Requests</div>
				<small class="text-muted d-block">Track your submitted documents</small>
			</a>
		</div>
		<div class="col-12 col-md-4">
			<a href="/user/profile" class="card action-card shadow-sm p-4 text-center text-decoration-none h-100">
				<div class="fs-1 mb-2">👤</div>
				<div class="fw-semibold">My Profile</div>
				<small class="text-muted d-block">View or edit your info</small>
			</a>
		</div>
	</div>

	<!-- Recent Requests -->
	<div class="recent-requests mb-4">
		<h5 class="fw-bold mb-3">Recent Requests</h5>

		<?php $recentRequests = getRequestByResidentsId($user['id']); ?>

		<?php if (empty($recentRequests)): ?>
			<div class="alert alert-light border text-center text-muted">
				<i class="bi bi-info-circle"></i> You haven’t made any document requests yet.
			</div>
		<?php else: ?>
			<div class="d-flex flex-column gap-3">
				<?php foreach ($recentRequests as $request): ?>
					<div class="card shadow-sm border-0">
						<div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
							<div>
								<h6 class="fw-semibold mb-1"><?= getDocumentName($request['document_type']) ?></h6>
								<small class="text-muted">Requested on <?= date("M d, Y", strtotime($request['created_at'])) ?></small>
							</div>
							<div class="text-end">
								<span class="badge 
									<?= $request['status'] === 'Approved' ? 'bg-success' : ($request['status'] === 'Pending' ? 'bg-warning text-dark' : ($request['status'] === 'Rejected' ? 'bg-danger' : 'bg-secondary')) ?>">
									<?= htmlspecialchars($request['status']) ?>
								</span>
								<?php if ($request['status'] === 'Approved'): ?>
									<a href="/documents/<?= $request['document_type'].'.php' ?>?<?= $request['id'] ?>" class="btn btn-sm btn-primary ms-2">
										<i class="bi bi-download"></i> Download
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

	<!-- Announcements -->
	<div class="announcements mb-4">
		<h5 class="fw-bold mb-3">Barangay Announcements</h5>
		<div id="announcementContainer" class="d-flex flex-column gap-3">
			<?php $announcements = getAnnouncements(); ?>
			<?php if (empty($announcements)): ?>
				<div class="alert alert-light border text-center text-muted">
					<i class="bi bi-broadcast-pin"></i> No announcements right now.
				</div>
			<?php else: ?>
				<?php foreach ($announcements as $a): ?>
					<div class="card shadow-sm border-0">
						<div class="card-body">
							<h6 class="fw-semibold mb-1"><?= htmlspecialchars($a['title']) ?></h6>
							<small class="text-muted d-block mb-2">
								<?= date("F j, Y", strtotime($a['date'])) ?>
								<?= $a['time'] ? ' — ' . date("g:i A", strtotime($a['time'])) : '' ?>
							</small>
							<p class="mb-0 text-secondary small"><?= htmlspecialchars($a['description']) ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>

</div>