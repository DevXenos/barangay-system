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
						<?php endif;
						foreach ($residents as $index => $resident): ?>
							<tr style="height: 60px;">
								<th scope="row"><?= $index + 1 ?></th>
								<td>John Reyes</td>
								<td>john.reyes@email.com</td>
								<td>Purok 1, Zone 2</td>
								<td>0917-111-2233</td>
								<td class="text-end">
									<div class="btn-group">
										<button class="btn btn-outline-primary btn-sm">
											<i class="bi bi-eye"></i>
										</button>
										<button class="btn btn-outline-secondary btn-sm">
											<i class="bi bi-pencil"></i>
										</button>
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