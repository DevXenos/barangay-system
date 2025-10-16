<?php include __DIR__ . '/lib.php'; ?>

<body class="min-vh-100 d-flex justify-content-center align-items-center bg-light">
	<div class="text-center p-5 rounded shadow-sm bg-white status-card">
		<div class="icon mb-3">
			<i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
		</div>
		<h2 class="text-dark fw-semibold mb-3">No Database Detected</h2>
		<p class="text-muted mb-4">
			The system was unable to connect to the configured database.
			Please verify your connection settings or contact the system administrator.
		</p>
		<button class="btn btn-primary px-4" id="retryBtn">Retry Connection</button>
	</div>

	<script type="module">
		document.title = 'No Database';
		document.getElementById('retryBtn').addEventListener('click', () => location.reload());
	</script>
</body>

</html>

<style>
	body {
		background: linear-gradient(180deg, #f6f9ff, #e9eef9);
		font-family: 'Segoe UI', Roboto, sans-serif;
		color: #212529;
	}

	.status-card {
		max-width: 480px;
		width: 100%;
		background: #fff;
		border: 1px solid rgba(0, 0, 0, 0.05);
		box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
		transition: transform 0.3s ease, box-shadow 0.3s ease;
	}

	.status-card:hover {
		transform: translateY(-3px);
		box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
	}

	h2 {
		font-size: 1.6rem;
	}

	p {
		font-size: 1rem;
		line-height: 1.6;
	}

	.btn-primary {
		background: linear-gradient(90deg, #007bff, #00aaff);
		border: none;
		box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
		transition: all 0.3s ease;
	}

	.btn-primary:hover {
		background: linear-gradient(90deg, #006ae0, #0090e0);
		transform: translateY(-2px);
		box-shadow: 0 6px 16px rgba(0, 123, 255, 0.35);
	}

	.text-muted {
		color: #6c757d !important;
	}
</style>