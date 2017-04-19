<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';

$module_no = 5;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		if ($_REQUEST['job'] == "select_mode") {
			$mode = $_POST['mode'];
			if ($mode == "Purchase Order") {
				header('Location: purchase_order_payment.php');
			}
			elseif ($mode == "Sales") {
				header('Location: sales_payment.php');
			}
			elseif ($mode == "Returns") {
				header('Location: return_sales_payment.php');
			}
			elseif ($mode == "Other Expenses") {
				header('Location: other_expenses.php');
			} else {
				header('Location: other_incomes.php');
			}

		} else {

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Payment");
			$smarty->display('payment/select_mode.tpl');
		}
	} else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access PAYMENT.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
} else {
	$smarty->assign('page', "Home");
	$smarty->display('index.tpl');
}