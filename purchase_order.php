<?php
require_once 'conf/smarty-conf.php';
include 'functions/inventory_functions.php';
include 'functions/purchase_order_functions.php';
include 'functions/user_functions.php';

include 'functions/navigation_functions.php';

$module_no = 4;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		if ($_REQUEST['job'] == 'purchase_item') {

			if (!isset ($_SESSION['purchase_order_no'])) {
				$_SESSION['purchase_order_no'] = get_purchase_no();
			} else {
			}

			$purchase_order_no = $_SESSION['purchase_order_no'];
			$info = get_purchase_order_info_by_purchase_no($purchase_order_no);
			if ($info['confirmed'] == 0) {
				$product_id = $_POST['product_id'];
				$product_name = $_POST['product_name'];
				$quantity = $_POST['qty'];
				$buying_price = $_POST['buying_price'];
				$catagory = $_POST['catagory'];
				$product_description = $_POST['product_description'];
				$measure_type = $_POST['measure_type'];
				$user_name = $_SESSION['user_name'];

				if (check_added_items_inventory($product_id) == 1) {
					$info = get_inventory_info_by_product_id($product_id);
					$old_catagory = $info['catagory'];
					$old_name = $info['product_name'];
					$selling_price = $info['selling_price'];
					$discount = $info['discount]'];
					$new_count = $old_count + $count;
					if ($old_catagory == $catagory) {
						save_item($product_id, $product_name, $quantity, $buying_price, $catagory, $product_description, $measure_type, $purchase_order_no, $user_name);
						$total = $quantity * $buying_price;
						add_purchase_order_item_ledger($purchase_order_no, $product_id, $total);
					} else {
						$smarty->assign('error_report', "on");
						$smarty->assign('error_message', "Catagory differs for this product ID.");
					}
				} else {
					save_item($product_id, $product_name, $quantity, $buying_price, $catagory, $product_description, $measure_type, $purchase_order_no, $user_name);
					$total = $quantity * $buying_price;
					//				add_purchase_order_item_ledger($purchase_order_no, $product_id, $total);
				}
			} else {
				$smarty->assign('error_report', "on");
				$smarty->assign('error_message', "Purchased Order Already Confirmed.");
			}
			$smarty->assign('parent_catagorys', list_parent_catagory());
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('purchase_order_no', "$_SESSION[purchase_order_no]");
			$smarty->assign('supplier_name', "$info[supplier_name]");
			$smarty->assign('date', "$info[date]");
			$smarty->assign('remarks', "$info[remarks]");
			$smarty->assign('total', get_total($_SESSION['purchase_order_no']));
			if ($_SESSION['edit'] == 1) {
				$smarty->assign('edit_mode', "on");
				$smarty->assign('prepared_by', "$info[prepared_by]");
				$smarty->assign('updated_by', "$_SESSION[user_name]");

			} else {
				$smarty->assign('prepared_by', "$_SESSION[user_name]");
			}
			$smarty->assign('page', "Purchase Order");
			$smarty->display('purchase_order/purchase_order.tpl');
		}

		elseif ($_REQUEST['job'] == 'search') {
			$_SESSION['purchase_order_no_search'] = $_POST['purchase_order_no_search'];
			$_SESSION['supplier_search'] = $_POST['supplier_search'];

			$smarty->assign('search_mode', "on");

			$smarty->assign('parent_catagorys', list_parent_catagory());
			$smarty->assign('purchase_order_no_search', "$_SESSION[purchase_order_no_search]");
			$smarty->assign('supplier_search', "$_SESSION[supplier_search]");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('total', "$total");
			$smarty->assign('page', "Purchase Order");
			$smarty->display('purchase_order/purchase_order.tpl');
		}

		elseif ($_REQUEST['job'] == 'edit') {
			$_SESSION['edit'] = 1;

			$_SESSION['id'] = $id = $_REQUEST['id'];
			$info = get_purchase_order_info($id);
			$_SESSION['purchase_order_no'] = $info['purchase_order_no'];
			$supplier_name = $info['supplier_name'];
			$remarks = $info['remarks'];
			$prepared_by = $info['prepared_by'];
			$date = $info['date'];

			$smarty->assign('edit_mode', "on");
			$smarty->assign('updated_by', "$_SESSION[user_name]");
			$smarty->assign('total', get_total($_SESSION['purchase_order_no']));
			$smarty->assign('parent_catagorys', list_parent_catagory());
			$smarty->assign('purchase_order_no', "$_SESSION[purchase_order_no]");
			$smarty->assign('supplier_name', "$info[supplier_name]");
			$smarty->assign('date', "$info[date]");
			$smarty->assign('remarks', "$info[remarks]");
			$smarty->assign('supplier_search', "$_SESSION[supplier_search]");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('purchase_order_no', "$_SESSION[purchase_order_no]");
			$smarty->assign('prepared_by', "$info[prepared_by]");
			$smarty->assign('page', "Purchase Order");
			$smarty->display('purchase_order/purchase_order.tpl');
		}
		elseif ($_REQUEST['job'] == 'delete_item') {
			$id = $_REQUEST['id'];
			$purchase_order_no = $_SESSION['purchase_order_no'];
			$info = get_purchase_order_info_by_purchase_no($purchase_order_no);

			if ($info['confirmed'] == 0) {
				delete_item($id);
				//		delete_purchase_order_item_ledger($id);
			} else {
				$smarty->assign('error_report', "on");
				$smarty->assign('error_message', "Purchased Order Already Confirmed.");
			}

			if ($_SESSION['edit'] == 1) {
				$smarty->assign('edit_mode', "on");
				$smarty->assign('prepared_by', "$info[prepared_by]");
				$smarty->assign('updated_by', "$_SESSION[user_name]");

			} else {
				$smarty->assign('prepared_by', "$_SESSION[user_name]");
			}

			$smarty->assign('supplier_name', "$info[supplier_name]");
			$smarty->assign('date', "$info[date]");
			$smarty->assign('remarks', "$info[remarks]");
			$smarty->assign('parent_catagorys', list_parent_catagory());
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('purchase_order_no', "$_SESSION[purchase_order_no]");
			$smarty->assign('total', get_total($_SESSION['purchase_order_no']));
			$smarty->assign('prepared_by', "$_SESSION[user_name]");
			$smarty->assign('page', "Purchase Order");
			$smarty->display('purchase_order/purchase_order.tpl');
		}
		elseif ($_REQUEST['job'] == 'purchase') {
			$purchase_order_no = $_SESSION['purchase_order_no'];
			$info = get_purchase_order_info_by_purchase_no($purchase_order_no);

			if ($info['confirmed'] == 0) {
				if ($_REQUEST['ok'] == 'Save') {
					$date = $_POST['date'];
					$remarks = $_POST['remarks'];
					$supplier_name = $_POST['supplier_name'];
					$prepared_by = $_POST['prepared_by'];
					$purchase_order_no = $_POST['purchase_order_no'];
					$total = get_total($_SESSION['purchase_order_no']);
					save_purchase_order($purchase_order_no, $date, $supplier_name, $prepared_by, $remarks, $total);
					//add_purchase_order_ledger($purchase_order_no);
				} else {

					$id = $_SESSION['id'];
					$date = $_POST['date'];
					$remarks = $_POST['remarks'];
					$supplier_name = $_POST['supplier_name'];
					$prepared_by = $_POST['prepared_by'];
					$updated_by = $_POST['updated_by'];
					$purchase_order_no = $_POST['purchase_order_no'];
					$total = get_total($_SESSION['purchase_order_no']);
					update_purchase_order($id, $purchase_order_no, $date, $supplier_name, $prepared_by, $remarks, $total, $updated_by);
					update_purchase_order_ledger($purchase_order_no);
					unset ($_SESSION['edit']);
				}

				update_saved($_SESSION['purchase_order_no']);
				unset ($_SESSION['purchase_order_no']);
			} else {
				$smarty->assign('error_report', "on");
				$smarty->assign('error_message', "Purchased Order Already Confirmed.");
			}

			$smarty->assign('parent_catagorys', list_parent_catagory());
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('purchase_order_no', "$_SESSION[purchase_order_no]");
			$smarty->assign('total', get_total($_SESSION['purchase_order_no']));
			$smarty->assign('page', "Purchase Order");
			$smarty->display('purchase_order/purchase_order.tpl');
		}

		elseif ($_REQUEST['job'] == 'must_new') {
			unset ($_SESSION['edit']);
			unset ($_SESSION['purchase_order_no']);
			unset ($_SESSION['remarks']);
			unset ($_SESSION['prepared_by']);
			unset ($_SESSION['updated_by']);
			unset ($_SESSION['supplier_name']);
			unset ($_SESSION['updated_by']);

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('parent_catagorys', list_parent_catagory());
			$smarty->assign('page', "Purchase Order");
			$smarty->display('purchase_order/purchase_order.tpl');
		}

		elseif ($_REQUEST['job'] == 'delete') {
			$module_no = 105;
			if (check_access($module_no, $_SESSION['user_id']) == 1) {
				$id = $_REQUEST['id'];
				$info = get_purchase_order_info($id);

				if ($info['confirmed'] == 0) {
					$info = get_purchase_order_info($id);
					$purchase_order_no_for_delete = $info['purchase_order_no'];

					calncel_items_for_purchase_order_no($purchase_order_no_for_delete);
					cancel_purchase_order($id);
					delete_purchase_order_ledger($purchase_order_no);
					delete_all_purchase_order_item_ledger($purchase_order_no);

				} else {
					$smarty->assign('error_report', "on");
					$smarty->assign('error_message', "Purchased Order Already Confirmed.");
				}

				$smarty->assign('search_mode', "on");
				unset ($_SESSION['purchase_order_no']);
				$smarty->assign('purchase_order_no_search', "$_SESSION[purchase_order_no_search]");
				$smarty->assign('supplier_search', "$_SESSION[supplier_search]");
				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('page', "Purchase Order");
				$smarty->display('purchase_order/purchase_order.tpl');
			} else {
				$user_name = $_SESSION['user_name'];
				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('error_report', "on");
				$smarty->assign('error_message', "Dear $user_name, you don't have permission to DELETE a purchase order.");
				$smarty->assign('page', "Access Error");
				$smarty->display('user_home/access_error.tpl');
			}
		} else {
			unset ($_SESSION['edit']);
			unset ($_SESSION['purchase_order_no']);
			unset ($_SESSION['remarks']);
			unset ($_SESSION['prepared_by']);
			unset ($_SESSION['updated_by']);
			unset ($_SESSION['supplier_name']);
			unset ($_SESSION['updated_by']);
			if (check_non_saved_purchase_order($_SESSION['user_name']) == 1) {
				$_SESSION['purchase_order_no'] = non_save_purchase_order_info($_SESSION['user_name']);

				$info = get_purchase_order_info_by_purchase_no($_SESSION['purchase_order_no']);
				$supplier_name = $info['supplier_name'];
				$remarks = $info['remarks'];
				$prepared_by = $info['prepared_by'];
				$date = $info['date'];

				if ($supplier_name) {
					$smarty->assign('new', "Skip Editing and <a href='purchase_order.php?job=must_new' style='color: orange; font-size: 20px;'> Create New Perchase Order.</a>");
					$smarty->assign('edit_mode', "on");
					$smarty->assign('updated_by', "$_SESSION[user_name]");
					$smarty->assign('supplier_name', "$info[supplier_name]");
					$smarty->assign('date', "$info[date]");
					$smarty->assign('remarks', "$info[remarks]");
					$smarty->assign('prepared_by', "$info[prepared_by]");
				} else {
					$smarty->assign('prepared_by', "$_SESSION[user_name]");
				}
			} else {

			}
			$total = get_total($_SESSION['purchase_order_no']);

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('parent_catagorys', list_parent_catagory());
			$smarty->assign('purchase_order_no', "$_SESSION[purchase_order_no]");

			$smarty->assign('total', "$total");
			$smarty->assign('page', "Purchase Order");
			$smarty->display('purchase_order/purchase_order.tpl');
		}
	} else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access PURCHASE ORDER.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
} else {
	$smarty->assign('page', "Home");
	$smarty->display('index.tpl');
}