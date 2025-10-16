<div class="flex-fill d-flex flex-column gap-3">
	<!-- Header -->
	<div class="header-container position-sticky d-flex justify-content-between align-items-center flex-wrap gap-2" style="top: 0; z-index: 100;">
		<div>
			<h4 class="fw-bold mb-0">Barangay Staff</h4>
			<small class="text-muted">Meet the people behind your barangay services</small>
		</div>
		<button id="newNewStaffBtn" class="btn btn-primary btn-sm">
			<i class="bi bi-person-plus-fill me-1"></i> Add New Staff
		</button>
	</div>

	<!-- Staff List Card -->
	<div class="card border-0 shadow-sm rounded-3">
		<div class="card-body p-0">
			<div class="table-responsive">
				<table id="staffTable" class="table table-hover align-middle mb-0">
					<thead class="table-light">
						<tr>
							<th scope="col">#</th>
							<th scope="col">Full Name</th>
							<th scope="col">Email</th>
							<th scope="col">Position</th>
							<th scope="col">Contact</th>
							<th scope="col" class="text-end">Actions</th>
						</tr>
					</thead>
					<tbody>
						<!-- To Include in reload div -->
						<?php $staffs = getAllStaffs(); ?>
						<?php foreach ($staffs as $index => $staff): ?>
							<tr>
								<th scope="row"><?= $index + 1 ?></th>
								<td><?= htmlspecialchars($staff['first_name'] . ' ' . $staff['last_name']) ?></td>
								<td><?= htmlspecialchars($staff['email']) ?></td>
								<td>
									<span class="badge bg-primary"><?= htmlspecialchars(ucfirst($staff['role'])) ?></span>
								</td>
								<td><?= htmlspecialchars($staff['phone_number']) ?></td>
								<td class="text-end">
									<div class="btn-group">
										<button class="btn btn-outline-primary btn-sm">
											<i class="bi bi-eye"></i>
										</button>
										<button class="btn-edit btn btn-outline-secondary btn-sm"
											data-id="<?= $staff['id'] ?>"
											data-first_name="<?= $staff['first_name'] ?>"
											data-last_name="<?= $staff['last_name'] ?>"
											data-email="<?= $staff['email'] ?>"
											data-phone_number="<?=$staff['phone_number']?>">
											<i class="bi bi-pencil"></i>
										</button>
										<button class="btn-delete btn btn-outline-danger btn-sm"
											data-id="<?= $staff['id'] ?>"
											data-first_name="<?= $staff['first_name'] ?>">
											<i class="bi bi-trash"></i>
										</button>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>

						<?php if (empty($staffs)): ?>
							<tr>
								<td colspan="6" class="text-center text-muted">No staff found.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>