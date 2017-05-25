<?php
require_once 'conf/smarty-conf.php';
include 'functions/purchase_order_functions.php';
include 'functions/confirm_functions.php';
include 'functions/inventory_functions.php';
include 'functions/user_functions.php';

include 'functions/navigation_functions.php';

$module_no = 6;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		if ($_REQUEST['job'] == "view") {
			$id = $_REQUEST['id'];
			$info = get_purchase_order_info($id);
			$_SESSION['purchase_order_no'] = $info['purchase_order_no'];

			$smarty->assign('view_mode', "on");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Confirm Purchase Order");
			$smarty->display('confirm/confirm.tpl');
		}
		elseif ($_REQUEST['job'] == 'search') {
			$_SESSION['purchase_order_no_search'] = $_POST['purchase_order_no_search'];
			$_SESSION['supplier_search'] = $_POST['supplier_search'];

			$smarty->assign('search_mode', "on");

			$smarty->assign('purchase_order_no_search', "$_SESSION[purchase_order_no_search]");
			$smarty->assign('supplier_search', "$_SESSION[supplier_search]");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Confirm Purchase Order");
			$smarty->display('confirm/confirm.tpl');
		}
		elseif ($_REQUEST['job'] == 'confirm') {
			$id = $_REQUEST['id'];

			$info = get_purchase_order_info($id);
			$purchase_order_no = $info['purchase_order_no'];

			update_confirmed($id);
			update_inventory($purchase_order_no);

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Confirm Purchase Order");
			$smarty->display('confirm/confirm.tpl');
		}
		else {
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Confirm Purchase Order");
			$smarty->display('confirm/confirm.tpl');
		}
	} else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access CONFIRM PURCHASE ORDER.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
} else {
	$smarty->assign('page', "Home");
	$smarty->display('index.tpl');
}