<?php
require_once 'conf/smarty-conf.php';
include 'functions/chart_of_accounts_functions.php';
include 'functions/user_functions.php';

include 'functions/navigation_functions.php';

$module_no = 8;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		if ($_REQUEST['job'] == "chart_of_accounts_form") {
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Chart Of Accounts");
			$smarty->display('chart_of_accounts/chart_of_accounts.tpl');
		}

		elseif ($_REQUEST['job'] == "add") {
			if ($_REQUEST['ok'] == 'Update') {
				$id = $_SESSION['id'];
				$info = get_account_info_by_id($id);

				$account_name = $_POST['account_name'];
				$account_code = $_POST['account_code'];
				$parent_account = $_POST['parent_account'];
				$category = $_POST['category'];
				$address = addslashes($_POST['address']);
				$contact_person = $_POST['contact_person'];
				$telephone = $_POST['telephone'];
				$fax = $_POST['fax'];
				$email = $_POST['email'];
				$account_status = $_POST['account_status'];
				$opening_balance = $_POST['opening_balance'];
				$opening_balance_date = $_POST['opening_balance_date'];
				$credit_limit = $_POST['credit_limit'];
				$credit_period = $_POST['credit_period'];

				update_account($id, $account_name, $account_code, $parent_account, $category, $address, $contact_person, $telephone, $fax, $email, $account_status, $opening_balance, $opening_balance_date, $credit_limit, $credit_period);
			} else {
				$account_name = $_POST['account_name'];
				$account_cde = $_POST['account_code'];
				$parent_account = $_POST['parent_accunt'];
				$category = $_POST['category'];
				$address = addslashes($_POST['address']);
				$contact_person = $_POST['contact_person'];
				$telephone = $_POST['telephone'];
				$fax = $_POST['fax'];
				$email = $_POST['email'];
				$account_status = $_POST['account_status'];
				$opening_balance = $_POST['opening_balance'];
				$opening_balance_date = $_POST['opening_balance_date'];
				$credit_limit = $_POST['credit_limit'];
				$credit_period = $_POST['credit_period'];

				save_account($account_name, $account_code, $parent_account, $category, $address, $contact_person, $telephone, $fax, $email, $account_status, $opening_balance, $opening_balance_date, $credit_limit, $credit_period);
			}

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Chart of Accounts");
			$smarty->display('chart_of_accounts/chart_of_accounts.tpl');
		}
		elseif ($_REQUEST['job'] == "edit") {
			$_SESSION['id'] = $id = $_REQUEST['id'];
			$info = get_account_info_by_id($id);
			$smarty->assign('account_name', $info['account_name']);
			$smarty->assign('account_code', $info['account_code']);
			$smarty->assign('parent_account', $info['parent_account']);
			$smarty->assign('category', $info['account_catagory']);
			$smarty->assign('address', $info['address']);
			$smarty->assign('telephone', $info['telephone']);
			$smarty->assign('fax', $info['fax']);
			$smarty->assign('email', $info['email']);
			$smarty->assign('contact_person', $info['contact_person']);
			$smarty->assign('account_status', $info['account_status']);
			$smarty->assign('opening_balance', $info['opening_balance']);
			$smarty->assign('opening_balance_date', $info['opening_balance_date']);
			$smarty->assign('credit_limit', $info['credit_limit']);
			$smarty->assign('credit_period', $info['credit_period']);

			$smarty->assign('edit_mode', 'on');
			$smarty->assign('edit', 'Accounts');
			$smarty->assign('page', "Chart of Accounts");
			$smarty->display('chart_of_accounts/chart_of_accounts.tpl');
		}
		elseif ($_REQUEST['job'] == 'search') {

			$_SESSION['search'] = $_POST['search'];

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('search', "$_SESSION[search]");
			$smarty->assign('search_mode', "on");
			$smarty->assign('page', "Chart of Accounts");
			$smarty->display('chart_of_accounts/chart_of_accounts.tpl');
		}
		elseif ($_REQUEST['job'] == "delete") {
			cancel_account($_REQUEST['id']);

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Chart of Accounts");
			$smarty->display('chart_of_accounts/chart_of_accounts.tpl');
		} else {
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Chart of Accounts");
			$smarty->display('chart_of_accounts/chart_of_accounts.tpl');
		}
	} else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access CHART OF ACCOUNTS.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
} else {
	$smarty->assign('page', "Home");
	$smarty->display('index.tpl');
}