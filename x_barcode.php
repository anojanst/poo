<?php

include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result=mysqli_query($conn, "SELECT * FROM inventory WHERE barcode='' OR barcode IS NULL");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo $row[product_id];
		$query = "UPDATE inventory SET
		barcode='$row[product_id]'
		WHERE product_id='$row[product_id]'";

	mysqli_query($conn, $query);
	}
	include 'conf/closedb.php';
?>