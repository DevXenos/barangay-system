<?php require __DIR__ . '/php/print.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Certificate of Indigency</title>
	<link rel="stylesheet" href="./style/print.css">
</head>

<body>

	<!-- PRINT BUTTON -->
	<button id="printBtn">🖨️ Print Certificate of Indigency</button>

	<!-- PAGE CONTAINER -->
	<div id="print-area" style="width: 8.5in; height: 11in; padding: 60px; border: 2px solid #000; margin: auto; position: relative; box-sizing: border-box; background-color: #fff;">

		<!-- WATERMARK -->
		<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.1;">
			<img src="seal.png" alt="Barangay Seal" style="width: 400px; height: 400px;">
		</div>

		<!-- HEADER -->
		<div style="text-align: center; line-height: 1.3; position: relative;">
			<img src="./../assets/img/logo.jpg" alt="Barangay Logo" style="width: 90px; height: 90px; position: absolute; left: 80px; top: 10px;">
			<p style="margin: 0; font-size: 14px;">Republic of the Philippines</p>
			<p style="margin: 0; font-size: 14px;">Province of <span style="font-weight: bold;"><?= $province ?></span></p>
			<p style="margin: 0; font-size: 14px;">Municipality of <span style="font-weight: bold;"><?= $municipality ?></span></p>
			<p style="margin: 0; font-size: 16px; font-weight: bold;">BARANGAY <span style="text-transform: uppercase;"><?= $barangayName ?></span></p>
			<hr style="width: 70%; border: 1px solid black; margin: 15px auto;">
			<h2 style="text-decoration: underline; font-weight: bold; margin: 10px 0;">CERTIFICATE OF INDIGENCY</h2>
		</div>

		<!-- BODY -->
		<div style="margin-top: 40px; text-align: justify; font-size: 16px; line-height: 1.8;">
			<p style="text-indent: 60px; margin-bottom: 25px;">
				TO WHOM IT MAY CONCERN:
			</p>

			<p style="text-indent: 60px;">
				This is to certify that <span style="font-weight: bold; text-transform: uppercase;"><?= $full_name ?></span>,
				of legal age, <?= $gender ?>, residing at <span style="font-weight: bold;"><?= $address ?></span>,
				is a bonafide resident of Barangay <span style="font-weight: bold;"><?= $barangayName ?></span>, Municipality of <span style="font-weight: bold;"><?= $municipality ?></span>, Province of <span style="font-weight: bold;"><?= $province ?></span>.
			</p>

			<p style="text-indent: 60px;">
				This is to certify further that the above-named person belongs to a low-income family and is considered indigent as defined under existing laws and guidelines of the barangay. This certification is issued upon request of the above-mentioned person for whatever legal purpose it may serve.
			</p>

			<p style="text-indent: 60px;">
				Issued this <span style="font-weight: bold;"><?= date('jS') ?></span> day of <span style="font-weight: bold;"><?= date('F Y') ?></span>
				at Barangay <span style="font-weight: bold;"><?= $barangayName ?></span>, Municipality of <span style="font-weight: bold;"><?= $municipality ?></span>,
				Province of <span style="font-weight: bold;"><?= $province ?></span>.
			</p>
		</div>

		<!-- SIGNATURE SECTION -->
		<div style="margin-top: 80px;">
			<div style="display: flex; justify-content: space-between; padding: 0 80px;">
				<div style="text-align: center;">
					<p style="margin-bottom: 40px;">__________________________</p>
					<p style="margin: 0; font-weight: bold;"><?= $full_name ?></p>
					<p style="margin: 0; font-size: 14px;">Applicant / Resident</p>
				</div>

				<div style="text-align: center;">
					<p style="margin-bottom: 40px;">__________________________</p>
					<p style="margin: 0; font-weight: bold;"><?= $captain ?></p>
					<p style="margin: 0; font-size: 14px;">Punong Barangay</p>
				</div>
			</div>
		</div>

		<!-- FOOTER -->
		<div style="margin-top: 100px; text-align: center;">
			<p style="margin: 0;">__________________________</p>
			<p style="margin: 0; font-weight: bold;"><?= $secretary ?></p>
			<p style="margin: 0; font-size: 14px;">Barangay Secretary</p>
			<p style="margin-top: 50px; font-size: 12px;">(This document is not valid without the Barangay Seal.)</p>
		</div>

	</div>

	<script src="./js/print.js"></script>

</body>

</html>