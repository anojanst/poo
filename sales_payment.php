<?php
require_once 'conf/smarty-conf.php';
include 'functions/sales_functions.php';
include 'functions/sales_payment_functions.php';
include 'functions/cheque_inventory_functions.php';
include 'functions/ledger_functions.php';
include 'functions/user_functions.php';

$module_no = 13;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		if ($_REQUEST['job'] == "customer") {
			$_SESSION['customer_name'] = $customer_name = $_POST['customer_name'];
			unset ($_SESSION['sales_no']);
			unset ($_SESSION['random_no']);
			$smarty->assign('customer_name', "$customer_name");
			$smarty->assign('show', "on");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Sales Payment");
			$smarty->display('payment/sales_payment.tpl');

		}
		elseif ($_REQUEST['job'] == "sales") {
			$_SESSION['sales_no'] = $sales_no = $_POST['sales_no'];
			unset ($_SESSION['random_no']);
			unset ($_SESSION['customer_name']);
			$smarty->assign('sales_no_select', "$sales_no");
			$smarty->assign('show', "on");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Sales Payment");
			$smarty->display('payment/sales_payment.tpl');

		}
		elseif ($_REQUEST['job'] == "add_pay") {

			$sales_no = $_REQUEST['sales_no'];
			$pay = $_POST['pay'];

			if (!isset ($_SESSION['random_no'])) {
				$_SESSION['random_no'] = $random_no = rand(1, 1000);
				;
			} else {

			}
			$random_no = $_SESSION['random_no'];
			$user_name = $_SESSION['user_name'];

			update_sales_due($sales_no, $pay);

			if (check_added_sales($sales_no, $random_no) == 1) {
				update_sales_payment_sales_in_temp_table($sales_no, $random_no, $pay);
			} else {
				save_sales_payment_sales_in_temp_table($sales_no, $random_no, $pay, $user_name);
			}

			$smarty->assign('customer_name', "$_SESSION[customer_name]");
			$smarty->assign('sales_no_select', "$_SESSION[sales_no]");
			$smarty->assign('added', "on");
			$smarty->assign('show', "on");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('prepared_by', "$_SESSION[user_name]");
			$smarty->assign('page', "Sales Payment");
			$smarty->display('payment/sales_payment.tpl');

		}

		elseif ($_REQUEST['job'] == "save_payment") {

			$random_no = $_SESSION['random_no'];
			if ($_SESSION['customer_name']) {
				$customer_name = $_SESSION['customer_name'];
			} else {
				$customer_info = get_sales_info_by_sales_no($_SESSION['sales_no']);
				$customer_name = $customer_info['customer_name'];
			}
			$date = $_POST['date'];
			$remarks = $_POST['remarks'];

			$cheque_amount = $_POST['cheque_amount'];
			$cheque_no = $_POST['cheque_no'];
			$cheque_bank = $_POST['cheque_bank'];
			$cheque_branch = $_POST['cheque_branch'];
			$cheque_date = $_POST['cheque_date'];
			$cash_amount = $_POST['cash_amount'];
			$discount = $_POST['discount'];
			$total = $cheque_amount + $cash_amount;

			$prepared_by = $_SESSION['user_name'];

			$sales_payment_no = get_sales_payment_no();

			save_sales_payment($sales_payment_no, $customer_name, $date, $remarks, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $cash_amount, $total, $prepared_by);
			transfer_sales($random_no, $sales_payment_no);
			delete_temp_data_sales_payment($random_no);

			if ($discount == 1) {
				add_discount_sales_payment_ledger($sales_payment_no);
			} else {
				add_sales_payment_ledger($sales_payment_no);
			}

			if ($cheque_no) {
				save_sales_payment_in_cheque_inventory($sales_payment_no, $cheque_amount, $cheque_no, $cheque_bank, $cheque_date, $date, $customer_name);
			} else {
			}

			unset ($_SESSION['random_no']);
			unset ($_SESSION['customer_name']);
			unset ($_SESSION['sales_no']);
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Sales Payment");
			$smarty->display('payment/sales_payment.tpl');
		}

		elseif ($_REQUEST['job'] == "delete_pay") {

			$id = $_REQUEST['id'];
			$sales_no = $_REQUEST['sales_no'];

			$info = get_sales_payment_info_from_temp($id);
			$sales_info = get_sales_info_by_sales_no($sales_no);

			$paid = $sales_info['paid'] - $info['amount'];
			$due = $sales_info['due'] + $info['amount'];
			$payment_status = $sales_info['payment_status'] - 1;

			update_sales_after_delete_temp($sales_no, $paid, $due, $payment_status);
			delete_sales_payment_from_temp($id);

			$smarty->assign('customer_name', "$_SESSION[customer_name]");
			$smarty->assign('sales_no_select', "$_SESSION[sales_no]");
			$smarty->assign('added', "on");
			$smarty->assign('show', "on");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Sales Payment");
			$smarty->display('payment/sales_payment.tpl');
		}

		elseif ($_REQUEST['job'] == 'search') {
			$_SESSION['sales_payment_no_search'] = $_POST['sales_payment_no_search'];
			$_SESSION['customer_search'] = $_POST['customer_search'];

			$smarty->assign('search_mode', "on");

			$smarty->assign('sales_payment_no_search', "$_SESSION[sales_payment_no_search]");
			$smarty->assign('customer_search', "$_SESSION[customer_search]");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('total', "$total");
			$smarty->assign('page', "Sales Payment");
			$smarty->display('payment/sales_payment.tpl');
		}

		elseif ($_REQUEST['job'] == "delete") {
			$module_no = 106;
			if (check_access($module_no, $_SESSION['user_id']) == 1) {
				$sales_payment_no = $_REQUEST['sales_payment_no'];

				roll_back_sales_payment($sales_payment_no);
				cancel_sales_payment($sales_payment_no);
				cancel_all_payment_has_sales($sales_payment_no);
				delete_sales_payment_ledger($sales_payment_no);
				delete_sales_payment_from_cheque_inventory($sales_payment_no);

				$smarty->assign('search_mode', "on");
				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('page', "Sales Payment");
				$smarty->display('payment/sales_payment.tpl');

			} else {
				$user_name = $_SESSION['user_name'];
				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('error_report', "on");
				$smarty->assign('error_message', "Dear $user_name, you don't have permission to DELETE a sales payment");
				$smarty->assign('page', "Access Error");
				$smarty->display('user_home/access_error.tpl');
			}
		}
		elseif ($_REQUEST['job'] == "view_receipt") {

			$rec_no = $_REQUEST['rec_no'];

			$receipt_info = get_receipt_info($_REQUEST['rec_no']);
			$invoice_no = receipt_get_invoice_no($receipt_info['rec_no']);
			$invoice_info = get_invoice_info($invoice_no);
			$customer_info = get_customer_info(addslashes($receipt_info['customer']));
			$job_info = get_job_info($invoice_info['job_no']);
			$_SESSION['rec_no'] = $_REQUEST['rec_no'];

			$smarty->assign('job_type', $job_info['job_type']);

			$smarty->assign('rec_no', $receipt_info['rec_no']);
			$smarty->assign('date', $receipt_info['date']);
			$smarty->assign('job_no', $invoice_info['job_no']);

			$smarty->assign('ex_rate', $invoice_info['ex_rate']);

			$smarty->assign('customer', $receipt_info['customer']);
			$smarty->assign('address', $customer_info['address']);
			$smarty->assign('total', strtoupper(num_to_rupee($receipt_info['cheque_amount'] + $receipt_info['cash_amount'])));

			$smarty->assign('cheque_amount', $receipt_info['cheque_amount']);
			$smarty->assign('cheque_no', $receipt_info['cheque_no']);
			$smarty->assign('cheque_bank', $receipt_info['cheque_bank']);
			$smarty->assign('cheque_branch', $receipt_info['cheque_branch']);
			$smarty->assign('cheque_date', $receipt_info['cheque_date']);
			$smarty->assign('cash_amount', $receipt_info['cash_amount']);
			$smarty->assign('prepared_by', $receipt_info['prepared_by']);
			$smarty->assign('remarks', $receipt_info['remarks']);

			$smarty->assign('notice', '&nbspPREVIEW.&nbsp');
			$smarty->display('receipt/receipt_report.tpl');
		}
		elseif ($_REQUEST['job'] == "print_receipt") {

			$module_no = 505;
			if (check_access($module_no, $_SESSION['user_id']) == 1) {
				$rec_no = $_REQUEST['rec_no'];
				$print_count = get_rec_print_count($rec_no);

				update_rec_print_count($rec_no, $print_count);
				$rec_no = $_REQUEST['rec_no'];

				$receipt_info = get_receipt_info($_REQUEST['rec_no']);
				$invoice_no = receipt_get_invoice_no($receipt_info['rec_no']);
				$invoice_info = get_invoice_info($invoice_no);
				$customer_info = get_customer_info(addslashes($receipt_info['customer']));
				$job_info = get_job_info($invoice_info['job_no']);
				$_SESSION['rec_no'] = $_REQUEST['rec_no'];

				$smarty->assign('job_type', $job_info['job_type']);
				$smarty->assign('print_count', $print_count);
				$smarty->assign('rec_no', $receipt_info['rec_no']);
				$smarty->assign('date', $receipt_info['date']);
				$smarty->assign('job_no', $invoice_info['job_no']);

				$smarty->assign('ex_rate', $invoice_info['ex_rate']);

				$smarty->assign('customer', $receipt_info['customer']);
				$smarty->assign('address', $customer_info['address']);
				$smarty->assign('total', strtoupper(num_to_rupee($receipt_info['cheque_amount'] + $receipt_info['cash_amount'])));

				$smarty->assign('cheque_amount', $receipt_info['cheque_amount']);
				$smarty->assign('cheque_no', $receipt_info['cheque_no']);
				$smarty->assign('cheque_bank', $receipt_info['cheque_bank']);
				$smarty->assign('cheque_branch', $receipt_info['cheque_branch']);
				$smarty->assign('cheque_date', $receipt_info['cheque_date']);
				$smarty->assign('cash_amount', $receipt_info['cash_amount']);
				$smarty->assign('prepared_by', $receipt_info['prepared_by']);
				$smarty->assign('remarks', $receipt_info['remarks']);

				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('page', "Sales Payment");
				$smarty->display('payment/sales_payment.tpl');
			} else {
				$smarty->display('home/access_error.tpl');
			}
		} else {
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Sales Payment");
			$smarty->display('payment/sales_payment.tpl');
		}

	} else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access SALES PAYMENT.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
} else {
	$smarty->assign('page', "Home");
	$smarty->display('index.tpl');
}