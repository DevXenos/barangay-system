<!-- set id to use on jquery load -->
<div id="requestContainer" class="d-flex flex-column gap-3">
	<?php $requests = getRequestByResidentsId($user['id']); ?>

	<?php if (empty($requests)): ?>
		<div class="text-center text-muted py-4">
			<i class="bi bi-file-earmark-exclamation fs-1 d-block mb-2"></i>
			No document requests found.
		</div>
	<?php else: ?>
		<?php foreach ($requests as $request): ?>
			<div class="card shadow-sm border-0">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-start">
						<div>
							<h6 class="mb-1 fw-bold"><?= getDocumentName($request['document_type']) ?></h6>
							<p class="mb-1 small text-muted">
								Request For: <?= $request['request_for'] ?> |
								Purpose: <?= $request['purpose'] ?>
							</p>
							<p class="mb-0 text-muted small">
								Submitted: <?= date('M d, Y', strtotime($request['created_at'])) ?>
							</p>
						</div>
						<?php
						$badgeClass = match ($request['status']) {
							'Pending' => 'bg-warning text-dark',
							'Approved' => 'bg-success',
							'Rejected' => 'bg-danger',
							'Cancelled' => 'bg-secondary',
							default => 'bg-light text-dark'
						};
						?>
						<span class="badge <?= $badgeClass ?>"><?= $request['status'] ?></span>
					</div>

					<div class="mt-3 d-flex gap-2">
						<!-- <button class="btn btn-sm btn-outline-info">
							<i class="bi bi-eye"></i> View
						</button> -->
						<?php if ($request['status'] === 'Pending'): ?>
							<button class="cancel-request-btn btn btn-sm btn-outline-danger" data-id="<?= $request['id'] ?>">
								<i class="bi bi-x-circle"></i> Cancel
							</button>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>

<script type="module" src="./../dist/user/my-requests.js"></script>