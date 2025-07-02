<?php
include 'header.php';
$backgroundColor = 'white';

$act = $_GET['act'] ?? $_POST['act'] ?? '';

if ($act === 'add') {
	$upc = $_POST['UPC'] ?? '';

	if ($upc) {
		$sql1 = "SELECT * FROM upc_main WHERE upc = '$upc'";
		$Query = mysqli_query($conn, $sql1);

		if (mysqli_num_rows($Query) === 0) {
			$backgroundColor = 'red';
			echo "Not found in database";
		} else {
			$backgroundColor = 'green';
			$qtyonhand = mysqli_num_rows($Query);
			$sql3 = "UPDATE upc_main SET qty = qty + 1 WHERE upc = '$upc'";
			mysqli_query($conn, $sql3);

			echo "Added<br><br>";
			while ($row3 = mysqli_fetch_array($Query)) {
				$rowcount = $row3['qty'] + 1;
				echo "$rowcount Boxes on hand";
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>UPC Management</title>
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
			setTimeout(() => {
				document.body.style.backgroundColor = "white";
			}, 1500);
		}
	</script>
</head>

<body onload="changeBackgroundColor()">

	<h2>UPC Management</h2>

	<div id="scanner-container">
		<div id="interactive" class="viewport"></div>
	</div>

	<form action="addbox.php" method="post">
		<table align="center">
			<tr><td>UPC</td></tr>
			<tr>
				<td><input type="text" name="UPC" id="UPC" autofocus onfocus="this.select()"></td>
			</tr>
		</table>
		<br>
		<input type="hidden" name="act" value="add">
		<input type="submit" value="Add Box">
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
				// Optional: strip first digit if needed, or keep full
				const trimmed = code.substring(1);
				document.getElementById('UPC').value = trimmed;
				document.getElementById('UPC').focus();
				document.getElementById('UPC').select();
				Quagga.stop(); // Stop after one scan (optional)
			}
		});
	</script>

</body>
</html>
