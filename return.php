<?php
require_once 'conf/smarty-conf.php';
include 'functions/inventory_functions.php';
include 'functions/return_functions.php';
include 'functions/user_functions.php';

$module_no = 18;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {

		if ($_REQUEST['job'] == 'select') {
			$selected_item = $_POST['selected_item'];
			if (!isset ($_SESSION['return_no'])) {
				$_SESSION['return_no'] = $return_no = get_return_no();
			} else {
			}
			$return_no = $_SESSION['return_no'];
			$return_info = get_return_info_by_return_no($return_no);

			$info = get_item_info_by_name($selected_item);
			$product_id = $info['product_id'];
			$stock = get_total_stock_return($info['product_id']);
			$quantity = get_quantity_return($product_id, $_SESSION['return_no']) + 1;

			if (check_added_items_return($product_id, $_SESSION['return_no']) == 1) {

				$info_for_return_has_items = get_product_info_from_return_has_items($product_id, $return_no);
				$selling_price = $info_for_return_has_items['selling_price'];
				$discount = $info_for_return_has_items['discount'];
				$item_total = ($quantity * $selling_price / 100) * (100 - $discount);

				if ($_SESSION['edit'] == 1 && $info_for_return_has_items['saved'] == 1) {
					reupdate_inventory_for_return($product_id, $info_for_return_has_items['quantity'], $stock);
				} else {
				}
				update_return_item_for_repeative_adding($product_id, $quantity, $item_total);
				update_return_item_ledger($product_id, $_SESSION['return_no']);
			} else {
				$discount = $info['discount'];
				$selling_price = $info['selling_price'];

				add_return_item($selected_item, $product_id, $stock, $selling_price, $discount, $_SESSION['return_no']);
				$total_to_ledger = ($selling_price / 100) * (100 - $discount);
				add_return_items_ledger($_SESSION['return_no'], $product_id, $total_to_ledger);

			}

			$smarty->assign('customer_name', "$return_info[customer_name]");
			$smarty->assign('date', "$return_info[date]");
			$smarty->assign('remarks', "$return_info[remarks]");
			$smarty->assign('return_no', "$_SESSION[return_no]");
			if ($_SESSION['edit'] == 1) {
				$smarty->assign('edit_mode', "on");
				$smarty->assign('prepared_by', "$return_info[prepared_by]");
				$smarty->assign('updated_by', "$_SESSION[user_name]");
			} else {
				$smarty->assign('prepared_by', "$_SESSION[user_name]");
			}
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('total', get_total_return($_SESSION['return_no']));
			$smarty->assign('page', "Return");
			$smarty->display('return/return.tpl');
		}

		elseif ($_REQUEST['job'] == 'update_item') {

			$product_id = $_REQUEST['product_id'];
			$quantity = $_POST['quantity'];
			$selling_price = $_POST['selling_price'];
			$discount = $_POST['discount'];
			$user_name = $_SESSION['user_name'];
			$item_total = ($quantity * $selling_price / 100) * (100 - $discount);
			$stock = get_total_stock_return($_REQUEST['product_id']);

			$return_no = $_SESSION['return_no'];
			$return_info = get_return_info_by_return_no($return_no);
			$item_info = get_product_info_from_return_has_items($product_id, $return_no);

			if ($_SESSION['edit'] == 1 && $item_info['saved'] == 1) {
				reupdate_inventory_for_return($product_id, $item_info['quantity'], $stock);
			} else {
			}
			update_return_item($product_id, $quantity, $item_total, $selling_price, $discount, $return_no, $stock);
			update_return_item_ledger($product_id, $return_no);

			$smarty->assign('customer_name', "$return_info[customer_name]");
			$smarty->assign('date', "$return_info[date]");
			$smarty->assign('remarks', "$return_info[remarks]");
			$smarty->assign('return_no', "$_SESSION[return_no]");
			if ($_SESSION['edit'] == 1) {
				$smarty->assign('edit_mode', "on");
				$smarty->assign('prepared_by', "$return_info[prepared_by]");
				$smarty->assign('updated_by', "$_SESSION[user_name]");

			} else {
				$smarty->assign('prepared_by', "$_SESSION[user_name]");
			}

			$smarty->assign('return_no', "$_SESSION[return_no]");
			$smarty->assign('prepared_by', "$_SESSION[user_name]");
			$smarty->assign('total', get_total_return($_SESSION['return_no']));
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "return");
			$smarty->display('return/return.tpl');
		}

		elseif ($_REQUEST['job'] == 'search') {
			$_SESSION['return_no_search'] = $_POST['return_no_search'];
			$_SESSION['customer_search'] = $_POST['customer_search'];

			$smarty->assign('search_mode', "on");
			unset ($_SESSION['return_no']);
			$smarty->assign('return_no_search', "$_SESSION[return_no_search]");
			$smarty->assign('customer_search', "$_SESSION[customer_search]");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('total', "$total");
			$smarty->assign('page', "Return");
			$smarty->display('return/return.tpl');
		}
		elseif ($_REQUEST['job'] == 'edit') {
			$_SESSION['edit'] = 1;

			$_SESSION['id'] = $id = $_REQUEST['id'];
			$info = get_return_info($id);
			$_SESSION['return_no'] = $info['return_no'];
			$supplier_name = $info['supplier_name'];
			$remarks = $info['remarks'];
			$prepared_by = $info['prepared_by'];
			$date = $info['date'];

			$smarty->assign('edit_mode', "on");
			$smarty->assign('updated_by', "$_SESSION[user_name]");
			$smarty->assign('total', get_total_return($_SESSION['return_no']));
			$smarty->assign('parent_catagorys', list_parent_catagory());
			$smarty->assign('return_no', "$_SESSION[return_no]");
			$smarty->assign('customer_name', "$info[customer_name]");
			$smarty->assign('date', "$info[date]");
			$smarty->assign('remarks', "$info[remarks]");
			$smarty->assign('supplier_search', "$_SESSION[supplier_search]");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('return_no', "$_SESSION[return_no]");
			$smarty->assign('prepared_by', "$info[prepared_by]");
			$smarty->assign('page', "Return");
			$smarty->display('return/return.tpl');
		}
		elseif ($_REQUEST['job'] == 'delete_item') {
			$id = $_REQUEST['id'];
			$info = get_product_info_from_return_has_items_by_id($id);
			$item_info = get_product_info_from_return_has_items($info['product_id'], $_SESSION['return_no']);
			$stock = get_total_stock_return($info['product_id']);

			if ($_SESSION['edit'] == 1 && $item_info['saved'] == 1) {
				reupdate_inventory_for_return($info['product_id'], $item_info['quantity'], $stock);
			} else {
			}
			cancel_item_return($id);
			delete_return_items_ledger($id);

			$return_no = $_SESSION['return_no'];
			$return_info = get_return_info_by_return_no($return_no);

			$smarty->assign('customer_name', "$return_info[customer_name]");
			$smarty->assign('date', "$return_info[date]");
			$smarty->assign('remarks', "$return_info[remarks]");
			$smarty->assign('return_no', "$_SESSION[return_no]");

			if ($_SESSION['edit'] == 1) {
				$smarty->assign('edit_mode', "on");
				$smarty->assign('prepared_by', "$return_info[prepared_by]");
				$smarty->assign('updated_by', "$_SESSION[user_name]");

			} else {
				$smarty->assign('prepared_by', "$_SESSION[user_name]");
			}

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('return_no', "$_SESSION[return_no]");
			$smarty->assign('total', get_total_return($_SESSION['return_no']));
			$smarty->assign('prepared_by', "$_SESSION[user_name]");
			$smarty->assign('page', "Return");
			$smarty->display('return/return.tpl');
		}

		elseif ($_REQUEST['job'] == 'return') {

			if ($_REQUEST['ok'] == 'Save') {
				$date = $_POST['date'];
				$remarks = $_POST['remarks'];
				$customer_name = $_POST['customer_name'];
				$prepared_by = $_POST['prepared_by'];
				$return_no = $_POST['return_no'];
				$total = get_total_return($_SESSION['return_no']);
				save_return($return_no, $date, $customer_name, $prepared_by, $remarks, $total);
				add_return_ledger($return_no);
			} else {

				$id = $_SESSION['id'];
				$date = $_POST['date'];
				$remarks = $_POST['remarks'];
				$customer_name = $_POST['customer_name'];
				$prepared_by = $_POST['prepared_by'];
				$updated_by = $_POST['updated_by'];
				$return_no = $_POST['return_no'];
				$total = get_total_return($_SESSION['return_no']);
				update_return($id, $return_no, $date, $customer_name, $prepared_by, $remarks, $total, $updated_by);
				update_return_ledger($return_no);
				unset ($_SESSION['edit']);
			}

			update_inventory_after_return($_SESSION['return_no']);
			update_saved_return($_SESSION['return_no']);
			unset ($_SESSION['return_no']);

			$smarty->assign('parent_catagorys', list_parent_catagory());
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('return_no', "$_SESSION[return_no]");
			$smarty->assign('total', get_total_return($_SESSION['return_no']));
			$smarty->assign('page', "Return");
			$smarty->display('return/return.tpl');
		}

		elseif ($_REQUEST['job'] == 'must_new') {
			unset ($_SESSION['edit']);
			unset ($_SESSION['return_no']);
			unset ($_SESSION['remarks']);
			unset ($_SESSION['prepared_by']);
			unset ($_SESSION['updated_by']);
			unset ($_SESSION['supplier_name']);
			unset ($_SESSION['updated_by']);

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('parent_catagorys', list_parent_catagory());
			$smarty->assign('page', "Return");
			$smarty->display('return/return.tpl');
		}

		elseif ($_REQUEST['job'] == 'delete') {
			$module_no = 104;
			if (check_access($module_no, $_SESSION['user_id']) == 1) {
				$id = $_REQUEST['id'];

				$info = get_return_info($id);
				$return_no_for_delete = $info['return_no'];

				calncel_items_for_return_no($return_no_for_delete);
				cancel_return($id);
				delete_return_ledger($return_no_for_delete);
				delete_all_return_items_ledger($return_no_for_delete);

				$smarty->assign('search_mode', "on");
				unset ($_SESSION['return_no']);
				$smarty->assign('return_no_search', "$_SESSION[return_no_search]");
				$smarty->assign('customer_search', "$_SESSION[customer_search]");
				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('page', "Return");
				$smarty->display('return/return.tpl');
			} else {
				$user_name = $_SESSION['user_name'];
				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('error_report', "on");
				$smarty->assign('error_message', "Dear $user_name, you don't have permission to DELETE return sales.");
				$smarty->assign('page', "Access Error");
				$smarty->display('user_home/access_error.tpl');
			}
		} else {
			unset ($_SESSION['edit']);
			unset ($_SESSION['return_no']);
			unset ($_SESSION['remarks']);
			unset ($_SESSION['prepared_by']);
			unset ($_SESSION['updated_by']);
			unset ($_SESSION['supplier_name']);
			unset ($_SESSION['updated_by']);
			if (check_non_saved_return_order($_SESSION['user_name']) == 1) {
				$_SESSION['return_no'] = non_save_return_info($_SESSION['user_name']);

				$info = get_return_info_by_return_no($_SESSION['return_no']);
				$customer_name = $info['customer_name'];
				$remarks = $info['remarks'];
				$prepared_by = $info['prepared_by'];
				$date = $info['date'];
				$_SESSION['edit'] = 1;
				if ($customer_name) {
					$smarty->assign('new', "Skip Editing and <a href='return.php?job=must_new' style='color: orange; font-size: 20px;'> Create New Perchase Order.</a>");
					$smarty->assign('edit_mode', "on");
					$smarty->assign('updated_by', "$_SESSION[user_name]");
					$smarty->assign('customer_name', "$info[customer_name]");
					$smarty->assign('date', "$info[date]");
					$smarty->assign('remarks', "$info[remarks]");
					$smarty->assign('prepared_by', "$info[prepared_by]");
				} else {
					$smarty->assign('prepared_by', "$_SESSION[user_name]");
				}
			} else {

			}
			$total = get_total_return($_SESSION['return_no']);

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('parent_catagorys', list_parent_catagory());
			$smarty->assign('return_no', "$_SESSION[return_no]");

			$smarty->assign('total', "$total");
			$smarty->assign('page', "Return");
			$smarty->display('return/return.tpl');
		}
	} else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access RETURN SALES.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
} else {
	$smarty->assign('page', "Home");
	$smarty->display('index.tpl');
}