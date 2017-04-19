<?php
include '../conf/config.php';
include '../conf/opendb.php';
//Include The Database Connection File 

$user_name=$_GET["user_name"];

$sql="SELECT * FROM users WHERE user_name = '$user_name'";
$result = mysql_query($sql,$conn);
$num=mysql_num_rows($result);
if ($num==1){
	echo '&nbsp;&nbsp;<img width="15" height="15" alt="" src="./images/close.png" /> &nbsp; Username is Existing	
      <input type="hidden" value="yes" name="key2" />';
   
}else {
	echo "&nbsp;&nbsp;<img width='15' height='15' alt=''src='./images/open.png' /> &nbsp;Username is available
     <input type='hidden'' value='no' name='key2' />";

}
?>