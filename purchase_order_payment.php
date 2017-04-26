<?php
require_once 'conf/smarty-conf.php';
include 'functions/purchase_order_functions.php';
include 'functions/purchase_order_payment_functions.php';
include 'functions/cheque_inventory_functions.php';
include 'functions/ledger_functions.php';
include 'functions/user_functions.php';

include 'functions/navigation_functions.php';

$module_no = 15;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		if ($_REQUEST['job'] == "supplier") {
			$_SESSION['supplier_name'] = $supplier_name = $_POST['supplier_name'];
			unset ($_SESSION['purchase_order_no']);
			unset ($_SESSION['random_no']);
			$smarty->assign('supplier_name', "$supplier_name");
			$smarty->assign('show', "on");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Purchase Order Payment");
			$smarty->display('payment/purchase_order_payment.tpl');

		}
		elseif ($_REQUEST['job'] == "purchase_order") {
			$_SESSION['purchase_order_no'] = $purchase_order_no = $_POST['purchase_order_no'];
			unset ($_SESSION['random_no']);
			unset ($_SESSION['supplier_name']);

			$smarty->assign('purchase_order_no_select', "$purchase_order_no");
			$smarty->assign('show', "on");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Purchase Order Payment");
			$smarty->display('payment/purchase_order_payment.tpl');

		}
		elseif ($_REQUEST['job'] == "add_pay") {

			$purchase_order_no = $_REQUEST['purchase_order_no'];
			$pay = $_POST['pay'];

			if (!isset ($_SESSION['random_no'])) {
				$_SESSION['random_no'] = $random_no = rand(1, 1000);
				;
			} else {

			}
			$random_no = $_SESSION['random_no'];
			$user_name = $_SESSION['user_name'];

			update_purchase_order_due($purchase_order_no, $pay);

			if (check_added_purchase_order($purchase_order_no, $random_no) == 1) {
				update_purchase_payment_purchase_order_in_temp_table($purchase_order_no, $random_no, $pay);
			} else {
				save_purchase_payment_purchase_order_in_temp_table($purchase_order_no, $random_no, $pay, $user_name);
			}

			$smarty->assign('supplier_name', "$_SESSION[supplier_name]");
			$smarty->assign('purchase_order_no_select', "$_SESSION[purchase_order_no]");
			$smarty->assign('added', "on");
			$smarty->assign('show', "on");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('prepared_by', "$_SESSION[user_name]");
			$smarty->assign('page', "Purchase Order Payment");
			$smarty->display('payment/purchase_order_payment.tpl');

		}

		elseif ($_REQUEST['job'] == "save_payment") {

			$random_no = $_SESSION['random_no'];
			if ($_SESSION['customer_name']) {
				$supplier_name = $_SESSION['supplier_name'];
			} else {
				$supplier_info = get_purchase_order_info_by_purchase_no($_SESSION['purchase_order_no']);
				$supplier_name = $supplier_info['supplier_name'];
			}
			$supplier_name = $_SESSION['supplier_name'];
			$date = $_POST['date'];
			$remarks = $_POST['remarks'];

			$cheque_amount = $_POST['cheque_amount'];
			$cheque_no = $_POST['cheque_no'];
			$cheque_bank = $_POST['cheque_bank'];
			$cheque_branch = $_POST['cheque_branch'];
			$cheque_date = $_POST['cheque_date'];
			$cash_amount = $_POST['cash_amount'];

			$total = $cheque_amount + $cash_amount;

			$prepared_by = $_SESSION['user_name'];

			$purchase_order_payment_no = get_purchase_order_payment_no();

			save_purchase_payment($purchase_order_payment_no, $supplier_name, $date, $remarks, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $cash_amount, $total, $prepared_by);
			transfer_purchase_order($random_no, $purchase_order_payment_no);
			delete_temp_data_purchase_payment($random_no);

			add_purchase_payment_ledger($purchase_order_payment_no);

			if ($cheque_no) {
				save_purchase_payment_in_cheque_inventory($purchase_order_payment_no, $cheque_amount, $cheque_no, $cheque_bank, $cheque_date, $date, $supplier_name);
			} else {
			}

			unset ($_SESSION['random_no']);
			unset ($_SESSION['customer_name']);
			unset ($_SESSION['purchase_order_no']);
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Purchase Order Payment");
			$smarty->display('payment/purchase_order_payment.tpl');
		}

		elseif ($_REQUEST['job'] == "delete_pay") {

			$id = $_REQUEST['id'];
			$purchase_order_no = $_REQUEST['purchase_order_no'];

			$info = get_purchase_payment_info_from_temp($id);
			$purchase_order_info = get_purchase_order_info_by_purchase_no($purchase_order_no);

			$paid = $purchase_order_info['paid'] - $info['amount'];
			$due = $purchase_order_info['due'] + $info['amount'];
			$payment_status = $purchase_order_info['payment_status'] - 1;

			update_purchase_order_after_delete_temp($purchase_order_no, $paid, $due, $payment_status);
			delete_purchase_payment_from_temp($id);

			$smarty->assign('supplier_name', "$_SESSION[supplier_name]");
			$smarty->assign('purchase_order_no_select', "$_SESSION[purchase_order_no]");
			$smarty->assign('added', "on");
			$smarty->assign('show', "on");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Purchase Order Payment");
			$smarty->display('payment/purchase_order_payment.tpl');
		}

		elseif ($_REQUEST['job'] == 'search') {
			$_SESSION['purchase_order_payment_no_search'] = $_POST['purchase_order_payment_no_search'];
			$_SESSION['supplier_search'] = $_POST['supplier_search'];

			$smarty->assign('search_mode', "on");

			$smarty->assign('purchase_order_payment_no_search', "$_SESSION[purchase_order_payment_no_search]");
			$smarty->assign('supplier_search', "$_SESSION[supplier_search]");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('total', "$total");
			$smarty->assign('page', "Purchase Order Payment");
			$smarty->display('payment/purchase_order_payment.tpl');
		}

		elseif ($_REQUEST['job'] == "delete") {
			$module_no = 108;
			if (check_access($module_no, $_SESSION['user_id']) == 1) {
				$purchase_order_payment_no = $_REQUEST['purchase_order_payment_no'];

				roll_back_purchase_payment($purchase_order_payment_no);
				cancel_purchase_payment($purchase_order_payment_no);
				cancel_all_payment_has_purchase($purchase_order_payment_no);
				delete_purchase_payment_ledger($purchase_order_payment_no);
				delete_purchase_payment_from_cheque_inventory($purchase_order_payment_no);

				$smarty->assign('search_mode', "on");
				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('page', "Purchase Order Payment");
				$smarty->display('payment/purchase_order_payment.tpl');
			} else {
				$user_name = $_SESSION['user_name'];
				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('error_report', "on");
				$smarty->assign('error_message', "Dear $user_name, you don't have permission to DELETE a purchase order payment.");
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
				$smarty->assign('page', "Purchase Order Payment");
				$smarty->display('payment/purchase_order_payment.tpl');
			} else {
				$smarty->display('home/access_error.tpl');
			}
		} else {
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Purchase Order Payment");
			$smarty->display('payment/purchase_order_payment.tpl');
		}

	} else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access PURCHASE ORDER PAYMENT.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
} else {
	$smarty->assign('page', "Home");
	$smarty->display('index.tpl');
}