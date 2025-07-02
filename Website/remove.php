<?php include 'header.php'; ?>

<?php
$backgroundColor = 'white';

if (!empty($_GET['act'])) {
	$act = $_GET['act'];
} else {
	$act = $_POST['act'] ?? '';
}

if ($act == 'remove') {
	$upc = $_POST['UPC'] ?? '';

	$sql1 = "SELECT * FROM upc_main WHERE upc = '$upc' AND qty > 0";
	$Query = mysqli_query($conn, $sql1);

	if (mysqli_num_rows($Query) == 0) {
		echo "Not found or no Inventory found";
		$backgroundColor = 'red';
	} else {
		$sql3 = "UPDATE upc_main SET qty = qty - 1 WHERE upc = '$upc'";
		mysqli_query($conn, $sql3);
		echo "Removed";
		$backgroundColor = 'green';
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Remove Box</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
	<style>
		body {
			transition: background-color 0.5s ease;
			background-color: <?= $backgroundColor ?>;
			font-family: sans-serif;
			text-align: center;
			padding: 10px;
		}

		#scanner-container {
			width: 100%;
			max-width: 480px;
			margin: 20px auto;
			border: 2px solid #1c59f2;
			border-radius: 8px;
			overflow: hidden;
			background: black;
		}

		#interactive {
			width: 100%;
			aspect-ratio: 4/3;
		}

		form {
			margin-top: 20px;
		}

		input[type="text"] {
			width: 90%;
			max-width: 400px;
			padding: 12px;
			font-size: 18px;
			margin-bottom: 10px;
		}

		input[type="submit"] {
			padding: 12px 24px;
			font-size: 18px;
			background-color: #1c59f2;
			color: white;
			border: none;
			border-radius: 6px;
			cursor: pointer;
		}
	</style>
	<script>
		function changeBackgroundColor() {
			setTimeout(function () {
				document.body.style.backgroundColor = "white";
			}, 1500);
		}
	</script>
</head>

<body onload="changeBackgroundColor()">

	<h2>Remove Box</h2>

	<div id="scanner-container">
		<div id="interactive" class="viewport"></div>
	</div>

	<form action="remove.php" method="post" class="submit">
		<table align="center">
			<tr><td>UPC</td></tr>
			<tr>
				<td><input type="text" name="UPC" id="UPC" autofocus onfocus="this.select()"></td>
			</tr>
		</table>
		<br>
		<input type="hidden" id="act" name="act" value="remove">
		<input type="submit" value="Remove">
	</form>

	<br>
	<a href="index.php">Home</a>

	<script>
		Quagga.init({
			inputStream: {
				name: "Live",
				type: "LiveStream",
				target: document.querySelector('#interactive'),
				constraints: {
					facingMode: "environment"
				}
			},
			decoder: {
				readers: ["ean_reader", "upc_reader"]
			}
		}, function (err) {
			if (err) {
				console.error(err);
				return;
			}
			Quagga.start();
		});

		Quagga.onDetected(function (data) {
			const code = data.codeResult.code;
			if (code) {
				const trimmed = code.substring(1); // remove first digit if needed
				document.getElementById('UPC').value = trimmed;
				document.getElementById('UPC').focus();
				document.getElementById('UPC').select();
				Quagga.stop(); // stop after one scan
			}
		});
	</script>

</body>
</html>
