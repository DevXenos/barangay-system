<?php
$header = 'BrgyOnline';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $header ?> <?= isset($title) ? " - " . $title : "" ?></title>

	<!-- Toastify -->
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
	<script type="text/javascript" defer src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

	<!-- Axios CDN -->
	<script defer src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

	<!-- JQuery -->
	<script defer src="https://code.jquery.com/jquery-3.7.1.js"></script>

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

	<!-- Bootstrap -->
	<link rel="stylesheet" href="../styles/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
	<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>