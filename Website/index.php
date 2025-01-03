<?php
include 'header.php';

$totalammo = 0; // Initialize total rounds to 0

// Fetch all the types of ammo
$sql = "
	SELECT 
		upc_detail.name, 
		upc_detail.grain, 
		upc_detail.manufacturer, 
		upc_detail.qtybox, 
		upc_detail.bullettype, 
		upc_detail.caliber, 
		upc_main.qty
	FROM upc_detail
	INNER JOIN upc_main ON upc_detail.upc = upc_main.upc
	ORDER BY upc_detail.caliber ASC
";
$query = mysqli_query($conn, $sql);


 
 
echo "<table border='2'><tr><td>";
if (mysqli_num_rows($query) > 0) {
	
	try {
		$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		// SQL query
		$sql = "
			SELECT 
				upc_detail.name, 
				upc_detail.grain, 
				upc_detail.manufacturer, 
				upc_detail.qtybox, 
				upc_detail.bullettype, 
				upc_detail.caliber, 
				upc_main.qty
			FROM upc_detail
			INNER JOIN upc_main ON upc_detail.upc = upc_main.upc
			ORDER BY upc_detail.caliber ASC
		";
		
		$stmt = $pdo->query($sql);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		// Get unique calibers and assign a random color to each
		$caliberColors = [];
		foreach ($rows as $row) {
			if (!isset($caliberColors[$row['caliber']])) {
				$caliberColors[$row['caliber']] = getRandomBrightColor();
			}
		}
	} catch (PDOException $e) {
		die("Database connection failed: " . $e->getMessage());
	}

	
	?>
	<table border="1" cellpadding="10" cellspacing="0">
		<thead>
			<tr>
				<th>Manufacturer</th>
				<th>Name</th>
				<th>Grain</th>
				<th>Qty/Box</th>
				<th>Bullet Type</th>
				<th>Caliber</th>
				<th>Qty</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($rows as $row): ?>
				<tr style="background-color: <?= $caliberColors[$row['caliber']]; ?>;">
					<td><?= htmlspecialchars($row['manufacturer']); ?></td>
					<td><?= htmlspecialchars($row['name']); ?></td>
					<td><?= htmlspecialchars($row['grain']); ?></td>
					<td><?= htmlspecialchars($row['qtybox']); ?></td>
					<td><?= htmlspecialchars($row['bullettype']); ?></td>
					<td><?= htmlspecialchars($row['caliber']); ?></td>
					<td><?= htmlspecialchars($row['qty']); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php
	
}

echo "</td><td style='vertical-align: top'>";

// Fetch distinct calibers
$sql2 = "SELECT DISTINCT caliber FROM upc_detail ORDER BY caliber ASC";
$query2 = mysqli_query($conn, $sql2);

if (mysqli_num_rows($query2) > 0) {
	echo "<table border='1'>
		<tr>
			<th style='text-align: center'>Caliber</th>
			<th style='text-align: center'>Qty On Hand</th>
		</tr>";

	while ($row2 = mysqli_fetch_array($query2)) {
		$totalrow = 0;
		$caliber = $row2['caliber'];

		// Calculate total rounds for each caliber
		$sql3 = "
			SELECT qtybox, qty 
			FROM upc_detail
			INNER JOIN upc_main ON upc_detail.upc = upc_main.upc
			WHERE caliber = '$caliber'
		";
		$query3 = mysqli_query($conn, $sql3);

		if (mysqli_num_rows($query3) > 0) {
			while ($row3 = mysqli_fetch_array($query3)) {
				$rowcount = $row3['qtybox'] * $row3['qty'];
				$totalrow += $rowcount; // Add to total rounds for this caliber
				$totalammo += $rowcount;
			}
		}

		echo "<tr>
			<td style='text-align: center'>{$row2['caliber']}</td>
			<td style='text-align: center'>{$totalrow}</td>
		</tr>";
	}
	echo "</table><br><br>";
}

echo "{$totalammo} Total rounds on hand";
echo "</td>";
echo "<td>
	<a href='addbox.php'>Scan box into inventory</a><br>
	<a href='add.php'>Add new type to inventory</a><br>
	<a href='remove.php'>Remove box from inventory</a><br>
</td></tr></table>";
?>
