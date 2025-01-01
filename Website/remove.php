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


if ($act=='remove'){
	$upc = $_POST['UPC'];

	
	$sql1="Select * from upc_main where upc= '$upc' and qty > 0";
	
	$Query = mysqli_query ($conn, $sql1);
	
	if(mysqli_num_rows($Query) == 0){
		print ("Not found or no Inventory found");
		$backgroundColor = 'red';
	}else{
		$sql3="UPDATE upc_main SET qty = qty - 1 WHERE upc = '$upc'";
		//echo $sql3;
		mysqli_query ($conn, $sql3);
		echo "Removed";
		$backgroundColor = 'green';
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
	
	<form action="remove.php" method="post" class="submit">
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
			<input type="hidden" id="act" name="act" value="remove">
			<input type="submit">
			</form>
			<A href='index.php'>Home</A></body>