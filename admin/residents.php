<!-- residents.php -->

<div class="flex-fill d-flex flex-column gap-3">

	<!-- Header -->
	<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
		<div>
			<h4 class="fw-bold mb-0">Registered Residents</h4>
			<small class="text-muted">List of all residents with active accounts</small>
		</div>
		<button class="btn btn-primary btn-sm">
			<i class="bi bi-person-plus-fill me-1"></i> Add New Resident
		</button>
	</div>

	<!-- Residents Table -->
	<div class="card border-0 shadow-sm rounded-3">
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead class="table-light">
						<tr>
							<th scope="col">#</th>
							<th scope="col">Full Name</th>
							<th scope="col">Email</th>
							<th scope="col">Address</th>
							<th scope="col">Contact</th>
							<th scope="col" class="text-end">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php $residents = getAllResidents(); ?>

						<?php if (empty($residents)): ?>
							<tr style="height: 60px;">
								<td colspan="6" class="text-center">No Residents</td>
							</tr>
						<?php endif; ?>
						<?php foreach ($residents as $index => $resident): ?>
							<tr style="height: 60px;">
								<th scope="row"><?= $index + 1 ?></th>
								<td><?= htmlspecialchars($resident['first_name'] . ' ' . ($resident['middle_name'] ?? '') . ' ' . $resident['last_name']) ?></td>
								<td><?= htmlspecialchars($resident['email']) ?></td>
								<td><?= htmlspecialchars($resident['address']) ?></td>
								<td><?= htmlspecialchars($resident['contact_number']) ?></td>
								<td class="text-end">
									<div class="btn-group">
										<!-- View Profile Button -->
										<a href="/admin/residents?profile_id=<?= urlencode($resident['id']) ?>" class="btn btn-outline-primary btn-sm d-flex justify-content-center align-items-center">
											<i class="bi bi-eye"></i>
										</a>

										<!-- Edit Button -->
										<button class="btn btn-outline-secondary btn-sm">
											<i class="bi bi-pencil"></i>
										</button>

										<!-- Delete Button -->
										<button class="btn btn-outline-danger btn-sm">
											<i class="bi bi-trash"></i>
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