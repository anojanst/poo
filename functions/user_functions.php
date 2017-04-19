<?php
function check_login($login, $passcode) {
		$passcode=md5($passcode);

		include 'conf/config.php';
		include 'conf/opendb.php';
		
		if(mysqli_num_rows(mysqli_query($conn, "SELECT id FROM employees WHERE user_name = '$login' AND password= '$passcode' AND cancel_status='0'"))){
			return 1;
		}
		else{
			return 0;
		}

		include 'conf/closedb.php';
}

function get_detail_info() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM detail");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_user_info($user_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM employees WHERE user_name='$user_name'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_user_info_id($user_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function update_detail($org_name, $address, $email, $telephone, $fax, $owner_name, $owner_email, $owner_telephone){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE detail SET
	org_name='$org_name',
	telephone='$telephone',
	address='$address',
	fax='$fax',
	owner_name='$owner_name',
	owner_email='$owner_email',
	owner_telephone='$owner_telephone',
	email='$email',
	filled='1'";

	mysqli_query($conn, $query);
	
	include 'conf/closedb.php';
}

function check_access($module_no, $user_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT count(id) FROM user_has_module WHERE user_id='$user_id' AND module_no='$module_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		if ($row['count(id)'] >=1) {
			return 1;
		}
		else{
			return 0;
		}
	}
	include 'conf/closedb.php';
}