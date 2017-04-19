<?php

$dbhost='localhost';
$dbuser='root';
$dbpass='raviprasath6112';
$dbname=$_SESSION['db'];
$conn = new PDO("mysql:host=".$dbhost.";port=8889;dbname=".$dbname, $dbuser, $dbpass);
//$conn=mysql_connect ($dbhost,$dbuser,$dbpass) or die ('I cannot connect to the database because:'. mysql_error());
//mysql_select_db($dbname);