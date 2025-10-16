<div class="flex-fill d-flex flex-column gap-3 align-items-stretch" style="overflow-y: auto; overflow-x: hidden;">
	<!-- === Top Summary Cards === -->
	<div class="row g-3">
		<div class="col-12 col-md-6 col-lg-3">
			<div class="card py-3 px-3">
				<i class="icon bi bi-people-fill"></i>
				<h6>Total Residents</h6>
				<div class="stat-value">2,432</div>
			</div>
		</div>
		<div class="col-12 col-md-6 col-lg-3">
			<div class="card py-3 px-3">
				<i class="icon bi bi-hourglass-split"></i>
				<h6>Pending Requests</h6>
				<div class="stat-value">84</div>
			</div>
		</div>
		<div class="col-12 col-md-6 col-lg-3">
			<div class="card py-3 px-3">
				<i class="icon bi bi-check2-circle"></i>
				<h6>Approved Requests</h6>
				<div class="stat-value">1,128</div>
			</div>
		</div>
		<div class="col-12 col-md-6 col-lg-3">
			<div class="card py-3 px-3">
				<i class="icon bi bi-person-badge-fill"></i>
				<h6>Staff Members</h6>
				<div class="stat-value">
					<?= count(getAllStaffs())?>
				</div>
			</div>
		</div>
	</div>

	<!-- === Overview Content === -->
	<div class="overview-grid">

		<!-- Announcements Section -->
		<div class="overview-section section-announcements">
			<div class="d-flex align-items-center justify-content-between">
				<h5>📢 Announcements</h5>

				<button id="addNewAnnouncementBtn" class="btn btn-outline-primary">
					Add Announcement
				</button>
			</div>

			<div id="announcementContainer" class="d-flex flex-column gap-3">
				<?php $announcements = getAllAnnouncement(); ?>
				<?php if (empty($announcements)): ?>
					<div style="border-radius: 12px;" class="shadow-sm p-3">No Announcement</div>
				<?php endif;
				// usort($announcements, function ($a, $b) {
				// 	return strtotime($b['date']) <=> strtotime($a['date']);
				// });
				foreach ($announcements as $announcement): ?>
					<div style="border-radius: 12px;" class="shadow-sm p-3 announcement-item">
						<span><?= $announcement['title'] ?></span>
						<span><?= date('F j, Y', strtotime($announcement['date'])) ?></span>
						<span>
							<?php
							$time = trim($announcement['time']);
							if ($time === '' || $time === '00:00' || $time === '00:00:00') {
								echo 'Whole day';
							} else {
								echo date('h:i A', strtotime($time));
							}
							?>
						</span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<!-- Requests Section -->
		<div class="overview-section section-requests">
			<h5>📄 Recent Requests</h5>
			<div class="request-status">#REQ_00123 – Barangay Clearance <strong>(Pending)</strong></div>
			<div class="request-status">#REQ_00122 – Residency Certificate <strong>(Approved)</strong></div>
			<div class="request-status">#REQ_00121 – Indigency Certificate <strong>(Rejected)</strong></div>
			<div class="request-status">#REQ_00120 – Business Permit <strong>(Processing)</strong></div>
		</div>

		<!-- Reports Section -->
		<div class="overview-section section-reports">
			<h5>📊 Reports Summary</h5>
			<div class="reports-summary">
				<p>Total Requests this Month: <strong>132</strong></p>
				<p>Completed: <strong>95</strong></p>
				<p>Pending: <strong>37</strong></p>
			</div>
		</div>

	</div>
</div>

<style>
	.card {
		border-radius: 16px;
		box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
		background: rgba(255, 255, 255, 0.8);
		backdrop-filter: blur(12px);
		border: 1px solid rgba(255, 255, 255, 0.4);
		transition: all 0.3s ease;
		cursor: pointer;
		position: relative;
		overflow: hidden;
	}

	.card:hover {
		transform: translateY(-5px);
		box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
	}

	.card::before {
		content: "";
		position: absolute;
		inset: 0;
		background: linear-gradient(135deg, rgba(0, 153, 255, 0.1), rgba(0, 255, 204, 0.1));
		opacity: 0;
		transition: 0.3s;
	}

	.card:hover::before {
		opacity: 1;
	}

	.card h6 {
		font-size: 0.9rem;
		font-weight: 600;
		color: #555;
		margin-bottom: 0.25rem;
	}

	.card .stat-value {
		font-size: 1.75rem;
		font-weight: 700;
		color: #0066ff;
	}

	.card .icon {
		position: absolute;
		top: 15px;
		right: 15px;
		font-size: 1rem;
		color: #0066ff;
		opacity: 0.4;
	}

	/* === Overview Grid Section === */
	.overview-grid {
		display: grid;
		grid-template-areas:
			"requests"
			"reports"
			"announcements";
		grid-template-columns: 1fr;
		gap: 1rem;
	}

	/* Desktop layout */
	@media (min-width: 992px) {
		.overview-grid {
			grid-template-areas:
				"announcements requests"
				"announcements reports";
			grid-template-columns: 2fr 1fr;
			height: calc(100vh - 140px);
			/* makes grid fill remaining height */
		}
	}

	/* === Each Section === */
	.overview-section {
		background: rgba(255, 255, 255, 0.8);
		padding: 1rem;
		border-radius: 16px;
		box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
		display: flex;
		flex-direction: column;
		gap: 0.75rem;
		position: relative;
		border: 1px solid rgba(255, 255, 255, 0.5);
		transition: 0.3s ease;
	}

	.overview-section h5 {
		font-weight: 700;
		margin-bottom: 0.25rem;
		color: #0048a5;
		display: flex;
		align-items: center;
		gap: 0.5rem;
	}

	.section-announcements {
		grid-area: announcements;
	}

	.section-requests {
		grid-area: requests;
	}

	.section-reports {
		grid-area: reports;
	}

	/* === Announcement Items === */
	.announcement-item {
		padding: 0.85rem 1rem;
		border: 1px solid #e4e9f1;
		border-radius: 10px;
		background: linear-gradient(to right, #f9fbff, #f3f7ff);
		transition: 0.3s;
		font-size: 0.95rem;
		display: flex;
		align-items: center;
		gap: 0.5rem;
	}

	.announcement-item:hover {
		background: linear-gradient(to right, #dbe8ff, #edf3ff);
		transform: translateX(4px);
	}

	.announcement-item::before {
		content: "•";
		color: #007bff;
		font-weight: bold;
	}

	.request-status {
		font-size: 0.9rem;
		color: #333;
		padding: 0.6rem 0.75rem;
		border-radius: 8px;
		background: #f9fafb;
		border: 1px solid #eee;
		transition: 0.25s;
	}

	.request-status:hover {
		background: #e9f1ff;
		transform: translateX(4px);
	}

	.request-status strong {
		color: #0066ff;
	}

	.reports-summary {
		display: flex;
		flex-direction: column;
		gap: 0.25rem;
	}

	.reports-summary p {
		margin: 0;
		font-size: 0.95rem;
		color: #333;
	}

	.reports-summary strong {
		color: #007bff;
	}
</style>