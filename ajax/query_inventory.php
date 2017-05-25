<?php
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'anojan10');
define('DB_NAME', 'rmihp632_pbd');


if (isset($_REQUEST['query'])){
	$return_arr = array();

	try {
	    $conn = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    
	    $stmt = $conn->prepare('SELECT product_name FROM inventory WHERE cancel_status="0" AND product_name LIKE :term ORDER BY product_name ASC');
	    $stmt->execute(array('term' => $_REQUEST['query'].'%'));
	    
	    while($row = $stmt->fetch()) {
	        $return_arr[] =  $row['product_name'];
	    }

	} catch(PDOException $e) {
	    echo 'ERROR: ' . $e->getMessage();
	}


    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
}


?>
