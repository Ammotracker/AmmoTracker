<?php

include 'header.php';

?>
	<head>
	<style>
		body {
			transition: background-color .5s ease;
		}
	</style>
</head>
<?php

IF(!$_GET['act']==''){
	$act = $_GET['act'];
}ELSE{
	$act = $_POST['act'];
}


if ($act=='add'){
	$upc = $_POST['UPC'];

	
	$sql1="Select * from upc_main where upc= '$upc'";
	
	$Query = mysqli_query ($conn, $sql1);
	
	if(mysqli_num_rows($Query) == 0){
		print ("Not found in database");
		$backgroundColor = 'red';
		
	}else{
		
		$backgroundColor = 'green';
		$qtyonhand = mysqli_num_rows($Query);
		$sql3="UPDATE upc_main SET qty = qty + 1 WHERE upc = '$upc'";
		//echo $sql3;
		mysqli_query ($conn, $sql3);
		echo "Added";
		echo "<BR><BR>";
		while($row3 = mysqli_fetch_array($Query)){
			$rowcount = $row3['qty'] + 1;
			echo $rowcount." Boxes on hand";
		}
	}
}
	
	?>

	<body bgcolor="<?= $backgroundColor; ?>" onload="changeBackgroundColor()">
	
		<script>
			function changeBackgroundColor() {
				setTimeout(function() {
					document.body.style.backgroundColor = "white"; // Change to white after 5 seconds
				}, 1500); // 1500ms = 1.5 seconds
			}
		</script>
	

	<form action="addbox.php" method="post" class="submit">
		<Table>
		<tr>
			<td >UPC</td>
		</tr>
		<TR>
			<td><input type="text" name="UPC" autofocus onfocus="this.select()"></td>
		</tr>
		</table>
				<BR>
				<BR>
	<!--the hidden post action-->
			<input type="hidden" id="act" name="act" value="add">
			<input type="submit">
			</form>
			<A href='index.php'>Home</A></body>
<?php		

?>

