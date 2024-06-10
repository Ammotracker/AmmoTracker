<?php

include 'header.php';


IF(!$_GET['act']==''){
	$act = $_GET['act'];
}ELSE{
	$act = $_POST['act'];
}


if ($act=='add'){
	$upc = $_POST['UPC'];
	$manf = $_POST['Manufacturer'];
	$name = $_POST['Name'];
	$qty = $_POST['qty'];
	$caliber = $_POST['caliber'];
	$grain = $_POST['grain'];
	$bullet = $_POST['bullet'];
	
	if($upc==''){
		echo "Field left blank";
	}
	
	$sql1="Select * from upc_main where upc= '$upc'";
	
	$Query = mysqli_query ($conn, $sql1);
	
	if(mysqli_num_rows($Query) == 0 && !$upc==''){
		$sql2 = "Insert into upc_main (upc, qty) Values ('$upc', '0')";
		mysqli_query ($conn, $sql2);
		$sql3="Insert into upc_detail (upc, caliber, qtybox, bullettype, manufacturer, name, grain) Values ('$upc', '$caliber', '$qty', '$bullet', '$manf', '$name', '$grain')";
		mysqli_query ($conn, $sql3);
		echo "Added to database";
	}else{
		echo "Already in the database";
	}
	
}
	?>
	<form action="add.php" method="post" class="submit">
		<Table>
		<tr>
			<TD> Manufacturer </TD>
			<TD> Product Name </TD>
			<TD> Qty per box</TD>
			<TD> Caliber</TD>
			<TD> Grain</TD>
			<TD> Bullet Type</TD>
			<td >UPC</td>
		</tr>
		<TR>
			
			<td><input type="text" name="Manufacturer" autofocus onfocus="this.select()"></td>
			<td><input type="text" name="Name"></td>
			<td><input type="text" name="qty"></td>
			<td><input type="text" name="caliber"></td>
			<td><input type="text" name="grain"></td>
			<td>
				<select type="select" name="bullet">
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
				<BR>
				<BR>
	<!--the hidden post action-->
			<input type="hidden" id="act" name="act" value="add">
			<input type="submit">
			</form>
			<A href='index.php'>Home</A>

