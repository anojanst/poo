<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';

$module_no = 7;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('page', "Reports");
		$smarty->display('reports/reports.tpl');
	} else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to VIEW REPORTS.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
} else {
	$smarty->assign('page', "Home");
	$smarty->display('index.tpl');
}