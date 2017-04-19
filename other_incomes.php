<?php
require_once 'conf/smarty-conf.php';
include 'functions/other_incomes_functions.php';
include 'functions/ledger_functions.php';
include 'functions/cheque_inventory_functions.php';
include 'functions/user_functions.php';

$module_no = 16;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		if ($_REQUEST['job'] == 'add_incomes') {

			if (!isset ($_SESSION['other_incomes_no'])) {
				$_SESSION['other_incomes_no'] = get_other_incomes_no();
			} else {
			}

			$other_incomes_no = $_SESSION['other_incomes_no'];
			$info = get_other_incomes_info_by_other_incomes_no($other_incomes_no);

			$detail = $_POST['detail'];
			$incomes_name = $_POST['incomes_name'];
			$amount = $_POST['amount'];
			$user_name = $_SESSION['user_name'];

			save_expense($incomes_name, $detail, $amount, $other_incomes_no, $user_name);

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('other_incomes_no', "$_SESSION[other_incomes_no]");
			$smarty->assign('total', get_incomes_total($_SESSION['other_incomes_no']));
			$smarty->assign('prepared_by', "$_SESSION[user_name]");
			$smarty->assign('page', "Other Incomes");
			$smarty->display('payment/other_incomes.tpl');
		}

		elseif ($_REQUEST['job'] == 'search') {
			$_SESSION['other_incomes_no_search'] = $_POST['other_incomes_no_search'];
			$_SESSION['customer_search'] = $_POST['customer_search'];

			$smarty->assign('search_mode', "on");

			$smarty->assign('other_incomes_no_search', "$_SESSION[other_incomes_no_search]");
			$smarty->assign('customer_search', "$_SESSION[customer_search]");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('total', "$total");
			$smarty->assign('page', "Other Incomes");
			$smarty->display('payment/other_incomes.tpl');
		}

		elseif ($_REQUEST['job'] == 'delete_expense') {
			$id = $_REQUEST['id'];
			$other_incomes_no = $_SESSION['other_incomes_no'];
			$info = get_other_incomes_info_by_other_incomes_no($other_incomes_no);

			delete_expense($id);

			$smarty->assign('prepared_by', "$_SESSION[user_name]");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('other_incomes_no', "$_SESSION[other_incomes_no]");
			$smarty->assign('total', get_incomes_total($_SESSION['other_incomes_no']));
			$smarty->assign('prepared_by', "$_SESSION[user_name]");
			$smarty->assign('page', "Other Incomes");
			$smarty->display('payment/other_incomes.tpl');
		}
		elseif ($_REQUEST['job'] == 'save') {
			$other_incomes_no = $_SESSION['other_incomes_no'];
			$info = get_other_incomes_info_by_other_incomes_no($other_incomes_no);

			$date = $_POST['date'];
			$remarks = $_POST['remarks'];
			$customer_name = $_POST['customer_name'];
			$cash_amount = $_POST['cash_amount'];
			$cheque_amount = $_POST['cheque_amount'];
			$cheque_no = $_POST['cheque_no'];
			$cheque_bank = $_POST['cheque_bank'];
			$cheque_branch = $_POST['cheque_branch'];
			$cheque_date = $_POST['cheque_date'];
			$temp_name = $_POST['temp_name'];
			$date = $_POST['date'];
			$prepared_by = $_POST['prepared_by'];
			$other_incomes_no = $_SESSION['other_incomes_no'];
			$total = get_incomes_total($_SESSION['other_incomes_no']);

			save_other_incomes($other_incomes_no, $date, $customer_name, $prepared_by, $remarks, $total, $cash_amount, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $temp_name);
			convert_other_incomes($other_incomes_no);
			add_other_incomes_ledger($other_incomes_no);
			update_incomes_saved($other_incomes_no);

			if ($cheque_no) {
				save_other_incomes_in_cheque_inventory($other_incomes_no, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $date, $customer_name);
			} else {
			}

			unset ($_SESSION['other_incomes_no']);

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('other_incomes_no', "$_SESSION[other_incomes_no]");
			$smarty->assign('total', get_incomes_total($_SESSION['other_incomes_no']));
			$smarty->assign('page', "Other Incomes");
			$smarty->display('payment/other_incomes.tpl');
		}

		elseif ($_REQUEST['job'] == 'delete') {
			$module_no = 109;
			if (check_access($module_no, $_SESSION['user_id']) == 1) {
				$id = $_REQUEST['id'];
				$info = get_other_incomes_info($id);

				$info = get_other_incomes_info($id);
				$other_incomes_no_for_delete = $info['other_incomes_no'];

				delete_other_incomes_ledger($other_incomes_no_for_delete);
				calncel_incomes_for_other_incomes_no($other_incomes_no_for_delete);
				cancel_other_incomes($id);
				delete_other_incomes_from_cheque_inventory($other_incomes_no_for_delete);

				$smarty->assign('search_mode', "on");
				unset ($_SESSION['other_incomes_no']);
				$smarty->assign('other_incomes_no_search', "$_SESSION[other_incomes_no_search]");
				$smarty->assign('customer_search', "$_SESSION[customer_search]");
				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('page', "Other Incomes");
				$smarty->display('payment/other_incomes.tpl');
			} else {
				$user_name = $_SESSION['user_name'];
				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('error_report', "on");
				$smarty->assign('error_message', "Dear $user_name, you don't have permission to access DELETE an other income.");
				$smarty->assign('page', "Access Error");
				$smarty->display('user_home/access_error.tpl');
			}
		} else {
			unset ($_SESSION['other_incomes_no']);

			if (check_non_saved_other_incomes($_SESSION['user_name']) == 1) {
				$_SESSION['other_incomes_no'] = non_save_other_incomes_info($_SESSION['user_name']);
			} else {
			}
			$total = get_incomes_total($_SESSION['other_incomes_no']);

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('other_incomes_no', "$_SESSION[other_incomes_no]");
			$smarty->assign('prepared_by', "$_SESSION[user_name]");
			$smarty->assign('total', "$total");
			$smarty->assign('page', "Other Incomes");
			$smarty->display('payment/other_incomes.tpl');
		}
	} else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access OTHER INCOMES.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
} else {
	$smarty->assign('page', "Home");
	$smarty->display('index.tpl');
}