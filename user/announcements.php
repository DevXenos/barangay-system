<!-- Announcements Container -->
<div id="announcementContainer" class="d-flex flex-column gap-3">
	<?php $announcements = getAnnouncements(); ?>

	<?php if (empty($announcements)): ?>
		<div class="alert alert-light border text-center text-muted shadow-sm mb-0">
			<i class="bi bi-info-circle"></i> No announcements at the moment.
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