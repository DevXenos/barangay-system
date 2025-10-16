<!-- requests.php -->
<div class="flex-fill d-flex flex-column gap-3">

	<!-- Header -->
	<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
		<div>
			<h4 class="fw-bold mb-0">Document Requests</h4>
			<small class="text-muted">Manage and review submitted document requests</small>
		</div>
		<div>
			<!-- <button class="btn btn-outline-primary btn-sm">
				<i class="bi bi-arrow-repeat me-1"></i> Refresh
			</button> -->
		</div>
	</div>

	<!-- Requests Table -->
	<div class="card border-0 shadow-sm rounded-3">
		<div class="card-body p-0">
			<div class="table-responsive">
				<table id="requestsTable" class="table table-hover align-middle mb-0">
					<thead class="table-light">
						<tr>
							<th scope="col">#</th>
							<th scope="col">Request No</th>
							<th scope="col">Resident Name</th>
							<th scope="col">Document Type</th>
							<th scope="col">Date Requested</th>
							<th scope="col">Status</th>
							<th scope="col" class="text-end">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php $requests = getAllRequests(); ?>
						<?php if (empty($requests)): ?>
							<tr>
								<td colspan="6">
									No Request
								</td>
							</tr>
						<?php endif; ?>

						<?php foreach ($requests as $index => $request): ?>
							<?php
							$status = strtolower($request['status']);
							$isPending = $status === 'pending';
							?>
							<tr>
								<th scope="row"><?= $index + 1 ?></th>
								<td><code><?= str_replace('request_', '', $request['id']) ?></code></td>
								<td><?= $request['first_name'] . ' ' . $request['last_name'] ?></td>
								<td><?= getDocumentName($request['document_type']) ?></td>
								<td><?= date('F d, Y', strtotime($request['created_at'])) ?></td>
								<td><span class="badge <?= getBadgeClass($request['status']) ?> text-dark"><?= $request['status'] ?></span></td>
								<td class="text-end">
									<div class="btn-group">
										<!-- View Details: Always enabled -->
										<?php
										$isApproved = $request['status'] === 'Approved';
										$icon = $isApproved ? 'bi-printer' : 'bi-eye';
										$title = $isApproved ? 'Print' : 'View';
										?>
										<button
											id="printBtn"
											class="btn btn-outline-success btn-sm"
											title="<?= $title ?>"
											data-id="<?= $request['id'] ?>"
											data-type="<?= $request['document_type'] ?>">
											<i class="bi <?= $icon ?>"></i>
										</button>

										<button id="acceptBtn" class="btn btn-outline-success btn-sm" title="Approve" <?= !$isPending ? 'disabled' : '' ?> data-id="<?= $request['id'] ?>" data-type="<?= $request['document_type'] ?>">
											<i class="bi bi-check2-circle"></i>
										</button>

										<!-- Reject: Enabled only if Pending -->
										<button id="rejectBtn" class="btn btn-outline-danger btn-sm" title="Reject" <?= !$isPending ? 'disabled' : '' ?> data-id="<?= $request['id'] ?>">
											<i class="bi bi-x-circle"></i>
										</button>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="module" src="./../dist/admin/requests.js"></script>

<style>
	body {
		background-color: #f8f9fa;
	}

	.card {
		border-radius: 14px;
		transition: transform 0.15s ease, box-shadow 0.15s ease;
	}

	.card:hover {
		transform: translateY(-2px);
		box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
	}

	.btn {
		border-radius: 8px;
	}
</style>