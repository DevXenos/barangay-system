<?php
$full_name = $user['first_name'] . " " . $user['middle_name'][0] . ". " . $user['last_name'];
?>

<!-- Header -->
<div class="bg-primary text-white header">
	<!-- Profile Picture -->
	<div class="bg-dark"
		style="width: 200px; aspect-ratio: 1/1; border-radius: 999px; overflow: hidden;">
		<!-- Add profile img here -->
	</div>

	<h3><?= $full_name ?></h3>
</div>

<div class="card shadow-sm">
	<div class="card-body">
		<h4 class="section-title text-primary mb-4">
			<i class="fas fa-user"></i>
			Personal Information
		</h4>

		<div class="row">
			<div class="col-12 col-lg-6">
				<label class="label">
					<h5>Birthdate</h5>
					<span>December 05 2003</span>
				</label>
				<label class="label">
					<h5>Gender</h5>
					<span>Male</span>
				</label>
				<label class="label">
					<h5>Civil Status</h5>
					<span>Married</span>
				</label>
			</div>

			<div class="col-12 col-lg-6">
				<label class="label">
					<h5>Contact Number</h5>
					<span>0912 345 6789</span>
				</label>
				<label class="label">
					<h5>Email Address</h5>
					<span>test@gmail.com</span>
				</label>
				<label class="label">
					<h5>Address</h5>
					<span>Don Pedro</span>
				</label>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12 col-sm-4">
		<button class="w-100 btn btn-primary">Edit Profile</button>
	</div>
	<div class="col-12 col-sm-4">
		<a href="/user/request-document" class="w-100 btn btn-secondary d-flex flex-column justify-content-center align-items-center">
			Request Document
		</a>
	</div>
	<div id="logoutBtn" class="col-12 col-sm-4">
		<button class="w-100 btn btn-danger">Logout</button>
	</div>
</div>

<script type="module" src="./../dist/user/profile.js"></script>

<style>
	.header {
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
		gap: 1rem;
		padding: 2rem 1rem;
		border-radius: 15px 15px 0 0;
	}

	.label {
		display: flex;
		flex-direction: column;
		height: 80px;
		justify-content: center;
		border-bottom: 1px solid #ccc;
	}
</style>