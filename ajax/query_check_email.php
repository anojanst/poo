<?php
include '../conf/config.php';
include '../conf/opendb.php';
//Include The Database Connection File

$email=$_GET["email"];
if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) {
	echo "&nbsp;&nbsp;<img width='15' height='15' alt='' src='./images/close.png' /> &nbsp; Email is not valid";
} 
else {
	$sql="SELECT * FROM users WHERE email = '$email'";
	$result = mysql_query($sql,$conn);
	$num=mysql_num_rows($result);
	if ($num==1){
		echo '&nbsp;&nbsp;<img width="15" height="15" alt="" src="./images/close.png" /> &nbsp; E-Mail Already is Existing
      <input type="hidden" value="yes" name="key3" />';
		 
	}else {
		echo "&nbsp;&nbsp;<img width='15' height='15' alt=''src='./images/open.png' /> &nbsp;Email is available
     <input type='hidden'' value='no' name='key3' />";

	}
}
?>