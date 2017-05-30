<?php

include 'conf/config.php';
include 'conf/opendb.php';
	
$result = mysqli_query($conn, "SELECT * FROM inventory WHERE cancel_status='0'");
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo $row['product_id'];
    if(check_multiple_stock($row['product_id'])==0){
        mysqli_select_db($conn, $dbname);
        $query = "INSERT INTO multiple_stock_has_inventory (id,product_id, product_name, branch,stock,reorder,location) 
        VALUES ('','$row[product_id]','$row[product_name]', 'STORE','0','0','COMMON')";
        
        mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
        echo " Added <br />";
    }

}

function check_multiple_stock($product_id){
    include 'conf/config.php';
    include 'conf/opendb.php';
        
    if(mysqli_num_rows(mysqli_query($conn, "SELECT id FROM multiple_stock_has_inventory WHERE product_id = '$product_id' AND branch='STORE'"))){
        return 1;
    }
    else{
        return 0;
    }

}
