<?php
include 'header.php';

// Get the action from GET or POST, fallback to empty string if not set
$act = $_GET['act'] ?? $_POST['act'] ?? '';

// Handle the 'add' action
if ($act === 'add') {
	// Retrieve POST data
	$upc = $_POST['UPC'] ?? '';
	$manf = $_POST['Manufacturer'] ?? '';
	$name = $_POST['Name'] ?? '';
	$qty = $_POST['qty'] ?? '';
	$caliber = $_POST['caliber'] ?? '';
	$grain = $_POST['grain'] ?? '';
	$bullet = $_POST['bullet'] ?? '';

	// Check if the UPC is provided
	if ($upc === '') {
		echo "Field left blank";
	} else {
		// Check if the UPC already exists in the database
		$sql1 = "SELECT * FROM upc_main WHERE upc = '$upc'";
		$Query = mysqli_query($conn, $sql1);

		if (mysqli_num_rows($Query) === 0) {
			// If the UPC doesn't exist, insert it into both tables
			$sql2 = "INSERT INTO upc_main (upc, qty) VALUES ('$upc', '0')";
			mysqli_query($conn, $sql2);

			$sql3 = "INSERT INTO upc_detail (upc, caliber, qtybox, bullettype, manufacturer, name, grain) 
					 VALUES ('$upc', '$caliber', '$qty', '$bullet', '$manf', '$name', '$grain')";
			mysqli_query($conn, $sql3);

			echo "Added to database";
		} else {
			echo "Already in the database";
		}
	}
}
?>

<form action="add.php" method="post" class="submit">
	<table>
		<tr>
			<td>Manufacturer</td>
			<td>Product Name</td>
			<td>Qty per box</td>
			<td>Caliber</td>
			<td>Grain</td>
			<td>Bullet Type</td>
			<td>UPC</td>
		</tr>
		<tr>
			<td><input type="text" name="Manufacturer" autofocus onfocus="this.select()"></td>
			<td><input type="text" name="Name"></td>
			<td><input type="text" name="qty"></td>
			<td><input type="text" name="caliber"></td>
			<td><input type="text" name="grain"></td>
			<td>
				<select name="bullet">
					<option value="FMJ">FMJ</option>
					<option value="HP">HP</option>
					<option value="Shot">Shot</option>
					<option value="Lead Round Nose">Lead Round Nose</option>
					<option value="Syntech">Syntech</option>
					<option value="Other">Other</option>
				</select>
			</td>
			<td><input type="text" name="UPC"></td>
		</tr>
	</table>

	<br><br>

	<!-- Hidden input to track the action -->
	<input type="hidden" id="act" name="act" value="add">
	<input type="submit" value="Add">
</form>
<a href="index.php">Home</a>