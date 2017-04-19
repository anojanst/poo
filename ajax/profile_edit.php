<?php
include '../conf/config.php';
include '../conf/opendb.php';
session_start();
$column=$_GET['column'];
$editval=strip_tags($_GET['editval']);
$user_name=$_SESSION['user_name'];


mysqli_query($conn, "UPDATE user_detail SET $column = '$editval' WHERE  user_name='$user_name'");
?>