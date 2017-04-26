<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';

$module_no = 1;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		if ($_REQUEST['job'] == 'save') {

			$org_name = $_POST['org_name'];
			$address = $_POST['address'];
			$email = $_POST['email'];
			$telephone = $_POST['telephone'];
			$fax = $_POST['fax'];
			$owner_name = $_POST['owner_name'];
			$owner_telephone = $_POST['owner_telephone'];
			$owner_email = $_POST['owner_email'];

			update_detail($org_name, $address, $email, $telephone, $fax, $owner_name, $owner_email, $owner_telephone);
			$_SESSION['org_name'] = $org_name;
			header('location: user_home.php');
		} else {
			$info = get_detail_info();

			$smarty->assign('org_name', "$info[org_name]");
			$smarty->assign('address', "$info[address]");
			$smarty->assign('telephone', "$info[telephone]");
			$smarty->assign('fax', "$info[fax]");
			$smarty->assign('email', "$info[email]");
			$smarty->assign('owner_name', "$info[owner_name]");
			$smarty->assign('owner_telephone', "$info[owner_telephone]");
			$smarty->assign('owner_email', "$info[owner_email]");

			$smarty->assign('page', "User Detail");
			$smarty->display('detail/detail.tpl');
		}
	} else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access USER SETTINGS.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
} else {
	$smarty->assign('error', "<p>Incorrect Login Details!</p>");
	$smarty->display('user_home/login.tpl');
}