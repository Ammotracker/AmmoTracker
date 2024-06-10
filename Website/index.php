<?php

include 'header.php';

$totalammo = 0; //set the total number of rounds on hand to 0 on page load

//Get all the types of ammo
$sql = "Select name, grain, manufacturer, qtybox, bullettype, name, caliber, qty from upc_detail inner join upc_main on upc_detail.upc = upc_main.upc order by caliber ASC";
$query = mysqli_query ($conn, $sql);

echo "<table border =2 ><TR><TD>";
if(mysqli_num_rows($query) > 0){ 
	echo "<table border = 1>";
	echo "<tr>";
	echo "<TH style='text-align: center'>Manufacturer</TH>";
	echo "<TH style='text-align: center'>Bullet</TH>";
	echo "<TH style='text-align: center'>Caliber</TH>";
	echo "<TH style='text-align: center'>Grain</TH>";
	echo "<TH style='text-align: center'>Qty per box</TH>";
	echo "<TH style='text-align: center'> Boxes On Hand</TH>";	
	echo "<TH style='text-align: center'> Rounds On Hand</TH>";

	echo "</tr>";
	while($row = mysqli_fetch_array($query)){
		echo "<TR>";
		echo "<TD style='text-align: center'>". $row['manufacturer']."</td>";
		echo "<TD style='text-align: center'>". $row['bullettype']."</td>";
		echo "<TD style='text-align: center'>". $row['caliber']."</td>";
		echo "<TD style='text-align: center'>". $row['grain']."</td>";
		echo "<TD style='text-align: center'>". $row['qtybox']."</td>";		
		$qtyonhand = $row['qtybox'] * $row['qty'];
		
		$totalammo = $totalammo + $qtyonhand;
		echo "<TD style='text-align: center'>". $row['qty']."</td>";
		echo "<TD style='text-align: center'>". $qtyonhand."</td>";

		echo "</tr>";
	}
	
	echo "</table><BR><BR>";
	

}
		
echo "</td><td style='vertical-align: top'>";
		
$sql2 = "Select distinct caliber from upc_detail order by caliber asc";
$query2 = mysqli_query ($conn, $sql2);

if(mysqli_num_rows($query2) > 0){ 
	echo "<table border = 1 >";
	echo "<tr>";
	echo "<TH style='text-align: center'>Caliber</TH>";
	echo "<TH style='text-align: center'>Qty On Hand</TH>";
	echo "</tr>";
	while($row2 = mysqli_fetch_array($query2)){
		$totalrow = 0;
		$caliber = $row2['caliber'];
		
		$sql3 = "Select qtybox, caliber, qty from upc_detail inner join upc_main on upc_detail.upc = upc_main.upc where caliber = '$caliber' order by caliber ASC";
		
		$query3 = mysqli_query ($conn, $sql3);
		
		if(mysqli_num_rows($query3) > 0){ 
			while($row3 = mysqli_fetch_array($query3)){
				$rowcount = $row3['qtybox'] * $row3['qty'];
				$totalrow = $totalrow + $rowcount;
			}
			
		}
		echo "<tr><TD style='text-align: center'>". $row2['caliber']. "</td>";
		echo "<TD style='text-align: center'>". $totalrow. "</td></tr>";
	}
	echo "</table><br><BR>";
	
}
echo $totalammo . " Total rounds on hand";
echo "</td>";
echo "<td><a href='addbox.php'>Scan box into inventory</a><BR>";
echo "<a href='add.php'>Add new type to inventory</a><BR>";
echo "<a href='remove.php'>Remove box from inventory</a><BR>";
echo "</td></tr></table>";


	