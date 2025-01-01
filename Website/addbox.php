<?php
// Include the header file
include 'header.php';

// Set the background color default to white
$backgroundColor = 'white';

// Get the action from GET or POST
$act = $_GET['act'] ?? $_POST['act'] ?? '';

// Handle the 'add' action
if ($act === 'add') {
	$upc = $_POST['UPC'] ?? '';

	// Check if UPC is provided
	if ($upc) {
		$sql1 = "SELECT * FROM upc_main WHERE upc = '$upc'";
		$Query = mysqli_query($conn, $sql1);

		// Check if UPC is found in the database
		if (mysqli_num_rows($Query) === 0) {
			$backgroundColor = 'red'; // Set background to red if not found
			echo "Not found in database";
		} else {
			$backgroundColor = 'green'; // Set background to green if found
			$qtyonhand = mysqli_num_rows($Query);
			$sql3 = "UPDATE upc_main SET qty = qty + 1 WHERE upc = '$upc'";
			mysqli_query($conn, $sql3); // Update the database

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
	<style>
		body {
			transition: background-color 0.5s ease;
		}
	</style>
	<script>
		// Function to change the background color to white after 1.5 seconds
		function changeBackgroundColor() {
			setTimeout(function() {
				document.body.style.backgroundColor = "white";
			}, 1500);
		}
	</script>
</head>
<body bgcolor="<?= $backgroundColor; ?>" onload="changeBackgroundColor()">

	<h2>UPC Management</h2>
	
	<!-- Form for adding box -->
	<form action="addbox.php" method="post">
		<table>
			<tr>
				<td>UPC</td>
			</tr>
			<tr>
				<td><input type="text" name="UPC" autofocus onfocus="this.select()"></td>
			</tr>
		</table>
		<br><br>
		<input type="hidden" id="act" name="act" value="add">
		<input type="submit" value="Add Box">
	</form>
	
	<br>
	<a href="index.php">Home</a>

</body>
</html>