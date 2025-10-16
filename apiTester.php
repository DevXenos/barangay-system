<?php
$title = "API Tester";
include __DIR__ . '/inc/lib.php';
?>

<body class="bg-light min-vh-100 d-flex flex-column">

	<div class="flex-fill container d-flex flex-column justify-content-center align-items-center">
		<form id="apiTesterForm" class="form d-flex flex-column gap-3 w-100" style="max-width: 500px;">
			<div class="mb-3">
				<label for="message" class="form-label fw-semibold">Message</label>
				<input name="message" type="text" id="message" class="form-control" placeholder="Enter message..." required>
			</div>

			<button id="apiTesterBtn" type="submit" class="btn btn-primary">Test API</button>
		</form>
	</div>

	<script type="module" src="./dist/apiTester.js"></script>
</body>

</html>