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
	<div class="row g-3">
		<div class="col-12 col-md-6 col-lg-3">
			<div class="card shadow-sm border-0 text-center py-3">
				<div class="card-body">
					<h6 class="text-muted mb-1">Total Requests</h6>
					<h3 class="fw-bold text-primary mb-0">132</h3>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-6 col-lg-3">
			<div class="card shadow-sm border-0 text-center py-3">
				<div class="card-body">
					<h6 class="text-muted mb-1">Approved</h6>
					<h3 class="fw-bold text-success mb-0">95</h3>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-6 col-lg-3">
			<div class="card shadow-sm border-0 text-center py-3">
				<div class="card-body">
					<h6 class="text-muted mb-1">Pending</h6>
					<h3 class="fw-bold text-warning mb-0">28</h3>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-6 col-lg-3">
			<div class="card shadow-sm border-0 text-center py-3">
				<div class="card-body">
					<h6 class="text-muted mb-1">Rejected</h6>
					<h3 class="fw-bold text-danger mb-0">9</h3>
				</div>
			</div>
		</div>
	</div>

	<!-- Reports Table -->
	<div class="card border-0 shadow-sm rounded-3">
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="table-light">
						<tr>
							<th scope="col">#</th>
							<th scope="col">Request No</th>
							<th scope="col">Resident</th>
							<th scope="col">Document Type</th>
							<th scope="col">Date</th>
							<th scope="col">Status</th>
							<th scope="col">Processed By</th>
						</tr>
					</thead>
					<tbody>
						<tr style="height: 60px;">
							<th scope="row">1</th>
							<td><code>REQ_00123</code></td>
							<td>Juan Dela Cruz</td>
							<td>Barangay Clearance</td>
							<td>Oct 10, 2025</td>
							<td><span class="badge bg-success">Approved</span></td>
							<td>Maria Santos</td>
						</tr>
						<tr style="height: 60px;">
							<th scope="row">2</th>
							<td><code>REQ_00124</code></td>
							<td>Jose Ramirez</td>
							<td>Certificate of Residency</td>
							<td>Oct 11, 2025</td>
							<td><span class="badge bg-warning text-dark">Pending</span></td>
							<td>—</td>
						</tr>
						<tr style="height: 60px;">
							<th scope="row">3</th>
							<td><code>REQ_00125</code></td>
							<td>Ana Lopez</td>
							<td>Indigency Certificate</td>
							<td>Oct 12, 2025</td>
							<td><span class="badge bg-danger">Rejected</span></td>
							<td>Jose Ramirez</td>
						</tr>
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

	/* Matches requests.php table row height */
	table tbody tr {
		height: 60px;
	}
</style>