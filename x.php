<?php

include 'conf/config.php';
include 'conf/opendb.php';

$i=0;
		$result=mysql_query("SELECT * FROM inventory WHERE type NOT LIKE 'SRI LANKA'" , $conn);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{	
			
			if($row['item_type']=="BOOK"){
				$pre="B";
			}
			else{
				$pre="A";
			}
			
			$no=$row['id'];
			$no = str_pad($no, 5, "0", STR_PAD_LEFT);
			$product_id=$pre.'-'.$no;
			
			echo "UPDATE inventory SET
			product_id='$product_id'
			WHERE product_id='$row[product_id]'"."</br>";
			
			mysql_select_db($dbname);
			$query = "UPDATE inventory SET
			product_id='$product_id'
			WHERE id='$row[id]'";
			
			mysql_query($query);
			$i++;
		}
		echo $i;

	include 'conf/closedb.php';
