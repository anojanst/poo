<?php
require_once 'conf/smarty-conf.php';
include 'functions/other_expenses_functions.php';
include 'functions/ledger_functions.php';
include 'functions/cheque_inventory_functions.php';
include 'functions/user_functions.php';

include 'functions/navigation_functions.php';

$module_no = 17;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		if ($_REQUEST['job'] == 'add_expenses') {

			if (!isset ($_SESSION['other_expenses_no'])) {
				$_SESSION['other_expenses_no'] = get_other_expenses_no();
			} else {
			}

			$other_expenses_no = $_SESSION['other_expenses_no'];
			$info = get_other_expenses_info_by_other_expenses_no($other_expenses_no);

			$detail = $_POST['detail'];
			$expenses_name = $_POST['expenses_name'];
			$amount = $_POST['amount'];
			$user_name = $_SESSION['user_name'];

			save_expense($expenses_name, $detail, $amount, $other_expenses_no, $user_name);

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('other_expenses_no', "$_SESSION[other_expenses_no]");
			$smarty->assign('total', get_expenses_total($_SESSION['other_expenses_no']));
			$smarty->assign('prepared_by', "$_SESSION[user_name]");
			$smarty->assign('page', "Other Expenses");
			$smarty->display('payment/other_expenses.tpl');
		}

		elseif ($_REQUEST['job'] == 'search') {
			$_SESSION['other_expenses_no_search'] = $_POST['other_expenses_no_search'];
			$_SESSION['supplier_search'] = $_POST['supplier_search'];

			$smarty->assign('search_mode', "on");

			$smarty->assign('other_expenses_no_search', "$_SESSION[other_expenses_no_search]");
			$smarty->assign('supplier_search', "$_SESSION[supplier_search]");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('total', "$total");
			$smarty->assign('page', "Other Expenses");
			$smarty->display('payment/other_expenses.tpl');
		}

		elseif ($_REQUEST['job'] == 'delete_expense') {
			$id = $_REQUEST['id'];
			$other_expenses_no = $_SESSION['other_expenses_no'];
			$info = get_other_expenses_info_by_other_expenses_no($other_expenses_no);

			delete_expense($id);

			$smarty->assign('prepared_by', "$_SESSION[user_name]");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('other_expenses_no', "$_SESSION[other_expenses_no]");
			$smarty->assign('total', get_expenses_total($_SESSION['other_expenses_no']));
			$smarty->assign('prepared_by', "$_SESSION[user_name]");
			$smarty->assign('page', "Other Expenses");
			$smarty->display('payment/other_expenses.tpl');
		}
		elseif ($_REQUEST['job'] == 'save') {
			$other_expenses_no = $_SESSION['other_expenses_no'];
			$info = get_other_expenses_info_by_other_expenses_no($other_expenses_no);

			$date = $_POST['date'];
			$remarks = $_POST['remarks'];
			$supplier_name = $_POST['supplier_name'];
			$cash_amount = $_POST['cash_amount'];
			$cheque_amount = $_POST['cheque_amount'];
			$cheque_no = $_POST['cheque_no'];
			$cheque_bank = $_POST['cheque_bank'];
			$cheque_branch = $_POST['cheque_branch'];
			$cheque_date = $_POST['cheque_date'];
			$temp_name = $_POST['temp_name'];
			$date = $_POST['date'];
			$prepared_by = $_POST['prepared_by'];
			$other_expenses_no = $_SESSION['other_expenses_no'];
			$total = get_expenses_total($_SESSION['other_expenses_no']);

			save_other_expenses($other_expenses_no, $date, $supplier_name, $prepared_by, $remarks, $total, $cash_amount, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $temp_name);
			convert_other_expenses($other_expenses_no);
			add_other_expenses_ledger($other_expenses_no);
			update_expenses_saved($other_expenses_no);

			if ($cheque_no) {
				save_other_expenses_in_cheque_inventory($other_expenses_no, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $date, $supplier_name);
			} else {
			}

			unset ($_SESSION['other_expenses_no']);

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('other_expenses_no', "$_SESSION[other_expenses_no]");
			$smarty->assign('total', get_expenses_total($_SESSION['other_expenses_no']));
			$smarty->assign('page', "Other Expenses");
			$smarty->display('payment/other_expenses.tpl');
		}

		elseif ($_REQUEST['job'] == 'delete') {
			$module_no = 110;
			if (check_access($module_no, $_SESSION['user_id']) == 1) {
				$id = $_REQUEST['id'];
				$info = get_other_expenses_info($id);

				$info = get_other_expenses_info($id);
				$other_expenses_no_for_delete = $info['other_expenses_no'];

				delete_other_expenses_ledger($other_expenses_no_for_delete);
				calncel_expenses_for_other_expenses_no($other_expenses_no_for_delete);
				cancel_other_expenses($id);
				delete_other_expenses_from_cheque_inventory($other_expenses_no_for_delete);

				$smarty->assign('search_mode', "on");
				unset ($_SESSION['other_expenses_no']);
				$smarty->assign('other_expenses_no_search', "$_SESSION[other_expenses_no_search]");
				$smarty->assign('supplier_search', "$_SESSION[supplier_search]");
				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('page', "Other Expenses");
				$smarty->display('payment/other_expenses.tpl');
			} else {
				$user_name = $_SESSION['user_name'];
				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('error_report', "on");
				$smarty->assign('error_message', "Dear $user_name, you don't have permission to DELETE an other expenses.");
				$smarty->assign('page', "Access Error");
				$smarty->display('user_home/access_error.tpl');
			}
		} else {
			unset ($_SESSION['other_expenses_no']);

			if (check_non_saved_other_expenses($_SESSION['user_name']) == 1) {
				$_SESSION['other_expenses_no'] = non_save_other_expenses_info($_SESSION['user_name']);
			} else {
			}
			$total = get_expenses_total($_SESSION['other_expenses_no']);

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('other_expenses_no', "$_SESSION[other_expenses_no]");
			$smarty->assign('prepared_by', "$_SESSION[user_name]");
			$smarty->assign('total', "$total");
			$smarty->assign('page', "Other Expenses");
			$smarty->display('payment/other_expenses.tpl');
		}
	} else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access OTHER EXPENSES.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
} else {
	$smarty->assign('page', "Home");
	$smarty->display('index.tpl');
}