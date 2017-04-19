<?php
$conn=mysqli_connect ($dbhost,$dbuser,$dbpass, $dbname) or die ('I cannot connect to the database because:'. mysql_error());
$conn_for_changing_db=mysqli_connect ($dbhost,$dbuser,$dbpass) or die ('I cannot connect to the database because:'. mysql_error());

mysqli_select_db($conn_for_changing_db, $dbname);
mysqli_query($conn, "SET character_set_results=utf8");
mysqli_query($conn, "SET names=utf8");
mysqli_query($conn, "SET character_set_client=utf8");
mysqli_query($conn, "SET character_set_connection=utf8");
mysqli_query($conn, "SET character_set_results=utf8");
mysqli_query($conn, "SET collation_connection=utf8_general_ci");
mysqli_query($conn, "SET @@global.sql_mode= '';");
?>
