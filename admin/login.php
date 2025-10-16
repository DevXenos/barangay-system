<body class="min-vh-100 d-flex flex-row">
	<div class="barangay-background flex-fill">
		<div class="overlay"></div>
		<div class="content">
			<h1>Barangay</h1>
			<h3>Administration</h3>
		</div>
	</div>

	<form id="adminLoginForm" class="form d-flex flex-column gap-3 p-5 justify-content-center align-content-center flex-fill" style="max-width: 500px; min-width: 300px;">

		<h1 class="text-center">Admin Login</h1>

		<h6 class="text-center">Please Login to Admin Dashboard</h6>

		<div class="form-floating custom-form-floating">
			<input name="email" type="email" class="form-control" id="emailInput" placeholder="" required>
			<label for="emailInput">Email address</label>
		</div>

		<div class="form-floating custom-form-floating" style="border-radius: 999px;">
			<input name="password" type="password" class="form-control" id="passwordInput" placeholder="">
			<label for="passwordInput">Password</label>
		</div>

		<button class="btn btn-primary">Login</button>
	</form>
	<script type="module" src="./../dist/admin/login.js"></script>
</body>
<style>
	.barangay-background {
		position: relative;
		background-image: url(/assets/img/barangay.jpg);
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
	}

	.barangay-background .overlay {
		position: absolute;
		inset: 0;
		background-color: var(--primary-darken);
		opacity: .95;
	}

	.content {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		padding: 2rem;
		display: flex;
		flex-direction: column;
		gap: 1rem;
		color: var(--secondary);
		text-align: center;

		h1 {
			font-size: 4.5rem;
		}

		h3 {
			font-size: 2rem;
		}
	}

	.custom-form-floating {
		border-radius: 0;
		border: 0;

		input {
			border: 0;
			border-radius: 0px;
			background-color: transparent;
			border-bottom: 2px solid var(--primary);
			transition: .3s;

			&:focus {
				background-color: transparent;
				box-shadow: 0 3px 0 var(--primary);
				border-color: var(--primary);
			}
		}
	}
</style>