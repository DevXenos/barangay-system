<!-- reports.php -->
<div class="flex-fill d-flex flex-column gap-3">

	<!-- Header -->
	<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
		<div>
			<h4 class="fw-bold mb-0">Reports</h4>
			<small class="text-muted">Summary and statistics of document requests</small>
		</div>
		<div>
			<button class="btn btn-outline-primary btn-sm">
				<i class="bi bi-download me-1"></i> Export Report
			</button>
		</div>
	</div>

	<!-- Summary Cards -->
	<div class="row g-3 m-0 g-0">
		<div class="col-12 col-md-6 col-lg-3">
			<div class="card shadow-sm border-0 text-center py-3">
				<div class="card-body">
					<h6 class="text-muted mb-1">Pending</h6>
					<h3 class="fw-bold text-primary mb-0">
						<?= count(getAllReports("Pending")) ?>
					</h3>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-6 col-lg-3">
			<div class="card shadow-sm border-0 text-center py-3">
				<div class="card-body">
					<h6 class="text-muted mb-1">Paid</h6>
					<h3 class="fw-bold text-success mb-0">
						<?= count(getAllReports("Paid")) ?>
					</h3>
				</div>
			</div>
		</div>
	</div>

	<!-- Reports Table -->
	<div class="card border-0 shadow-sm rounded-3">
		<div class="card-body p-0">
			<div class="table-responsive">
				<table id="reportsTableContainer" class="table table-hover align-middle mb-0">
					<thead class="table-light">
						<tr>
							<th scope="col">#</th>
							<th scope="col">Request No</th>
							<th scope="col">Resident Name</th>
							<th scope="col">Document Type</th>
							<th scope="col">Date</th>
							<th scope="col">Status</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $reports = getAllReports() ?>
						<?php if (empty($reports)): ?>
							<tr style="height: 60px;">
								<td colspan="7" class="text-center">
									No Reports
								</td>
							</tr>
						<?php endif; ?>

						<?php foreach ($reports as $index => $report): ?>
							<?php
							$owner = getRequestById($report['request_id']);
							$owner_name = $owner['first_name'] . " " . $owner['last_name'];
							$document_type = $owner['document_type'];
							?>
							<tr style="height: 60px;">
								<th scope="row"><?= $index + 1 ?></th>
								<td><code><?= $report['request_id'] ?></code></td>
								<td><?= $owner_name ?></td>
								<td><?= getDocumentName($document_type) ?></td>
								<td><?= date("M j, Y", strtotime($report['created_at'])) ?></td>
								<td>
									<?php if ($report['status'] === 'Pending'): ?>
										<span class="badge bg-warning text-dark">Pending</span>
									<?php else: ?>
										<span class="badge bg-success">Paid</span>
									<?php endif; ?>
								</td>
								<td>
									<?php if ($report['status'] === 'Pending'): ?>
										<form class="mark-paid-form" style="margin:0;">
											<input type="hidden" name="report_id" value="<?= $report['id'] ?>">
											<button type="submit" name="pay_report" class="btn btn-sm btn-success">Mark Paid</button>
										</form>
									<?php else: ?>
										<span class="text-muted">—</span>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>

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

	h3 {
		font-size: 1.75rem;
	}

	.btn {
		border-radius: 8px;
	}

	table tbody tr {
		height: 60px;
	}
</style>

<script type="module" src="./../dist/admin/reports.js"></script>