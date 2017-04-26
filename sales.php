<?php
require_once 'conf/smarty-conf.php';
include 'functions/inventory_functions.php';
include 'functions/sales_functions.php';
include 'functions/ledger_functions.php';
include 'functions/user_functions.php';

$module_no = 3;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {

	if ($_REQUEST['job']=='barcode'){
		$selected_item=$_POST['barcode'];
		if (!isset($_SESSION['sales_no'])) {
			$_SESSION['sales_no']=$sales_no=get_sales_no();
		}
		else{
		}
		$sales_no=$_SESSION['sales_no'];
		$sales_info=get_sales_info_by_sales_no($sales_no);

		$info=get_item_info_by_name($selected_item);
		$product_name=$info['product_name'];
        $product_id=$info['product_id'];
		//$stock=get_total_stock($info['product_id']);
		$stock = get_branch_stock($product_id);
		$quantity=get_quantity($product_id, $_SESSION['sales_no'])+1;

		if(check_added_items($product_id, $_SESSION['sales_no'])==1){
			$info_for_sales_has_items=get_product_info_from_sales_has_items($product_id, $sales_no);
			$selling_price=$info_for_sales_has_items['selling_price'];
			$discount=$info_for_sales_has_items['discount'];
            $quantity=$quantity+1;
			$item_total=($quantity*$selling_price/100)*(100-$discount);
			
			/*if($stock<$quantity){

				$smarty->assign('error_report',"on");
				$smarty->assign('error_message',"Not Enough Stock.");
			}
			
			else{
			*/	
				if($_SESSION['edit']==1 && $info_for_sales_has_items['saved']==1){
					reupdate_inventory($product_id, $info_for_sales_has_items['quantity'], $stock);
				}
				else{
				}
				update_sales_item_for_repeative_adding($product_id, $quantity, $item_total);
				//			update_sales_item_ledger($product_id ,$_SESSION['sales_no']);
			//}
		}
		else{
			$discount=$info['discount'];
			$selling_price=$info['selling_price'];
			
			/*
			if($stock<$quantity){
				$smarty->assign('error_report',"on");
				$smarty->assign('error_message',"Not Enough Stock.");
			}
			
			else{
			*/	
				add_sales_item($selected_item, $product_name, $stock, $selling_price, $discount, $_SESSION['sales_no']);
				$total_to_ledger=($selling_price/100)*(100-$discount);
                add_sales_items_ledger($_SESSION['sales_no'], $product_id, $total_to_ledger);
			//} 
		}

		$smarty->assign('customer_name',"$sales_info[customer_name]");
		$smarty->assign('date',"$sales_info[date]");
		$smarty->assign('remarks',"$sales_info[remarks]");
		$smarty->assign('sales_no',"$_SESSION[sales_no]");
		if($_SESSION['edit']==1){
			$smarty->assign('edit_mode',"on");
			$smarty->assign('prepared_by',"$sales_info[prepared_by]");
			$smarty->assign('updated_by',"$_SESSION[user_name]");
		}
		else{
			$smarty->assign('prepared_by',"$_SESSION[user_name]");
		}
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('total',get_total_sales($_SESSION['sales_no']));
		$smarty->assign('page',"sales");
		$smarty->display('sales/sales.tpl');
	}

	elseif($_REQUEST['job']=='update_item'){

		$product_id=$_REQUEST['product_id'];
		$quantity=$_POST['quantity'];
		$selling_price=$_POST['selling_price'];
		$discount=$_POST['discount'];
		$user_name=$_SESSION['user_name'];
		$item_total=($quantity*$selling_price/100)*(100-$discount);
		//$stock=get_total_stock($_REQUEST['product_id']);
		$stock = get_branch_stock($product_id);

		$sales_no=$_SESSION['sales_no'];
		$sales_info=get_sales_info_by_sales_no($sales_no);
		$item_info=get_product_info_from_sales_has_items($product_id, $sales_no);
		
		/*
		if($stock<$quantity){
			$smarty->assign('error_report',"on");
			$smarty->assign('error_message',"Not Enough Stock.");
		}
		else{
		*/	
			if($_SESSION['edit']==1 && $item_info['saved']==1){
				reupdate_inventory($product_id, $item_info['quantity'], $stock);
			}
			else{
			}
			update_sales_item($product_id, $quantity, $item_total, $selling_price, $discount, $sales_no, $stock);
			update_sales_item_ledger($product_id ,$sales_no);
		//}

		$smarty->assign('customer_name',"$sales_info[customer_name]");
		$smarty->assign('date',"$sales_info[date]");
		$smarty->assign('remarks',"$sales_info[remarks]");
		$smarty->assign('sales_no',"$_SESSION[sales_no]");
		if($_SESSION['edit']==1){
			$smarty->assign('edit_mode',"on");
			$smarty->assign('prepared_by',"$sales_info[prepared_by]");
			$smarty->assign('updated_by',"$_SESSION[user_name]");

		}
		else{
			$smarty->assign('prepared_by',"$_SESSION[user_name]");
		}

		$smarty->assign('sales_no',"$_SESSION[sales_no]");
		$smarty->assign('prepared_by',"$_SESSION[user_name]");
		$smarty->assign('total',get_total_sales($_SESSION['sales_no']));
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('page',"sales");
		$smarty->display('sales/sales.tpl');
	}

	elseif ($_REQUEST['job']=='search'){
		$_SESSION['sales_no_search']=$_POST['sales_no_search'];
		$_SESSION['customer_search']=$_POST['customer_search'];

		$smarty->assign('search_mode',"on");
		unset($_SESSION['sales_no']);
		$smarty->assign('sales_no_search',"$_SESSION[sales_no_search]");
		$smarty->assign('customer_search',"$_SESSION[customer_search]");
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('total',"$total");
		$smarty->assign('page',"sales");
		$smarty->display('sales/sales.tpl');
	}
	elseif ($_REQUEST['job']=='edit'){
		$_SESSION['edit']=1;


		$_SESSION['id']=$id=$_REQUEST['id'];
		$info=get_sales_info($id);
		$_SESSION['sales_no']=$info['sales_no'];
		$supplier_name=$info['supplier_name'];
		$remarks=$info['remarks'];
		$prepared_by=$info['prepared_by'];
		$date=$info['date'];

		$smarty->assign('edit_mode',"on");
		$smarty->assign('updated_by',"$_SESSION[user_name]");
		$smarty->assign('total',get_total_sales($_SESSION['sales_no']));
		$smarty->assign('parent_catagorys',list_parent_catagory());
		$smarty->assign('sales_no',"$_SESSION[sales_no]");
		$smarty->assign('customer_name',"$info[customer_name]");
		$smarty->assign('date',"$info[date]");
		$smarty->assign('remarks',"$info[remarks]");
		$smarty->assign('supplier_search',"$_SESSION[supplier_search]");
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('sales_no',"$_SESSION[sales_no]");
		$smarty->assign('prepared_by',"$info[prepared_by]");
		$smarty->assign('page',"sales");
		$smarty->display('sales/sales.tpl');
	}
	elseif ($_REQUEST['job']=='delete_item'){
		$id=$_REQUEST['id'];
		$info=get_product_info_from_sales_has_items_by_id($id);
		$item_info=get_product_info_from_sales_has_items($info['product_id'], $_SESSION['sales_no']);
		$stock=get_total_stock($info['product_id']);

		if($_SESSION['edit']==1 && $item_info['saved']==1){
			reupdate_inventory($info['product_id'], $item_info['quantity'], $stock);
		}
		else{
		}
		cancel_item($id);
		delete_sales_items_ledger($id);

		$sales_no=$_SESSION['sales_no'];
		$sales_info=get_sales_info_by_sales_no($sales_no);

		$smarty->assign('customer_name',"$sales_info[customer_name]");
		$smarty->assign('date',"$sales_info[date]");
		$smarty->assign('remarks',"$sales_info[remarks]");
		$smarty->assign('sales_no',"$_SESSION[sales_no]");

		if($_SESSION['edit']==1){
			$smarty->assign('edit_mode',"on");
			$smarty->assign('prepared_by',"$sales_info[prepared_by]");
			$smarty->assign('updated_by',"$_SESSION[user_name]");
		}
		else{
			$smarty->assign('prepared_by',"$_SESSION[user_name]");
		}

		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('sales_no',"$_SESSION[sales_no]");
		$smarty->assign('total',get_total_sales($_SESSION['sales_no']));
		$smarty->assign('prepared_by',"$_SESSION[user_name]");
		$smarty->assign('page',"sales");
		$smarty->display('sales/sales.tpl');
	}


	elseif($_REQUEST['job']=='sales'){

		if($_REQUEST['ok']=='Finish the Bill & Print'){
			$date=$_POST['date'];
			$remarks=$_POST['remarks'];
            $discount=$_POST['discount'];
			$customer_name=$_POST['customer_name'];
            $customer_amount=$_POST['customer_amount'];
			$prepared_by=$_POST['prepared_by'];
			$sales_no=$_POST['sales_no'];
			$total=get_total_sales($_SESSION['sales_no']);
            $total_after_discount= $total-$discount;
            $balance=$customer_amount-$total_after_discount;
			save_sales($sales_no, $date, $customer_name, $prepared_by, $remarks,$discount,$customer_amount, $total_after_discount, $total,$balance);
			add_sales_ledger($sales_no);
		}
		else {

			$id=$_SESSION['id'];
			$date=$_POST['date'];
			$remarks=$_POST['remarks'];
            $discount=$_POST['discount'];
			$customer_name=$_POST['customer_name'];
			$prepared_by=$_POST['prepared_by'];
			$updated_by=$_POST['updated_by'];
			$sales_no=$_POST['sales_no'];
			$total=get_total_sales($_SESSION['sales_no']);
			update_sales($id, $sales_no, $date, $customer_name, $prepared_by, $remarks,$discount, $total, $updated_by);
			update_sales_ledger($sales_no);
			unset($_SESSION['edit']);
		}

		$branch= $_SESSION['branch'];
		
		update_inventory_after_sales_in_branch($_SESSION['sales_no'],$branch);
		update_inventory_after_sales($_SESSION['sales_no']);
		update_saved_sales($_SESSION['sales_no']);
		
		
        $_SESSION['print_no']=$_SESSION['sales_no'];
		unset($_SESSION['sales_no']);
        $date = date("Y-m-d");

		$smarty->assign('parent_catagorys',list_parent_catagory());
		$smarty->assign('org_name',"$_SESSION[org_name]");
        $smarty->assign('date',"$date");
		$smarty->assign('sales',"$_SESSION[print_no]");
		$smarty->assign('total',get_total_sales($_SESSION['sales_no']));
		$smarty->assign('page',"sales");
		$smarty->display('sales/print.tpl');
	}

	elseif ($_REQUEST['job']=='must_new'){
		unset($_SESSION['edit']);
		unset($_SESSION['sales_no']);
		unset($_SESSION['remarks']);
		unset($_SESSION['prepared_by']);
		unset($_SESSION['updated_by']);
		unset($_SESSION['supplier_name']);
		unset($_SESSION['updated_by']);


		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('parent_catagorys',list_parent_catagory());
		$smarty->assign('page',"sales");
		$smarty->display('sales/sales.tpl');
	}

	elseif ($_REQUEST['job']=='delete'){
		$module_no = 103;
			if (check_access($module_no, $_SESSION['user_id']) == 1) {
		$id=$_REQUEST['id'];

		$info=get_sales_info($id);
		$sales_no_for_delete=$info['sales_no'];

		calncel_items_for_sales_no($sales_no_for_delete);
		cancel_sales($id);
		delete_sales_ledger($sales_no_for_delete);
		delete_all_sales_items_ledger($sales_no_for_delete);

		$smarty->assign('search_mode',"on");
		unset($_SESSION['sales_no']);
		$smarty->assign('sales_no_search',"$_SESSION[sales_no_search]");
		$smarty->assign('customer_search',"$_SESSION[customer_search]");
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('page',"sales");
		$smarty->display('sales/sales.tpl');
	} else {
				$user_name = $_SESSION['user_name'];
				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('error_report', "on");
				$smarty->assign('error_message', "Dear $user_name, you don't have permission to DELETE a sales.");
				$smarty->assign('page', "Access Error");
				$smarty->display('user_home/access_error.tpl');
			}
		}


	else {
		unset($_SESSION['edit']);
		unset($_SESSION['sales_no']);
		unset($_SESSION['remarks']);
		unset($_SESSION['prepared_by']);
		unset($_SESSION['updated_by']);
		unset($_SESSION['supplier_name']);
		unset($_SESSION['updated_by']);
		if(check_non_saved_sales_order($_SESSION['user_name'])==1){
			$_SESSION['sales_no']=non_save_sales_info($_SESSION['user_name']);

			$info=get_sales_info_by_sales_no($_SESSION['sales_no']);
			$customer_name=$info['customer_name'];
			$remarks=$info['remarks'];
			$prepared_by=$info['prepared_by'];
			$date=$info['date'];
			$_SESSION['edit']=1;
			if ($customer_name){
				$smarty->assign('new',"Skip Editing and <a href='sales.php?job=must_new' style='color: orange; font-size: 20px;'> Create New Perchase Order.</a>");
				$smarty->assign('edit_mode',"on");
				$smarty->assign('updated_by',"$_SESSION[user_name]");
				$smarty->assign('customer_name',"$info[customer_name]");
				$smarty->assign('date',"$info[date]");
				$smarty->assign('remarks',"$info[remarks]");
				$smarty->assign('prepared_by',"$info[prepared_by]");
			}
			else {
				$smarty->assign('prepared_by',"$_SESSION[user_name]");
			}
		}
		else{

		}
		$total=get_total_sales($_SESSION['sales_no']);

		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('parent_catagorys',list_parent_catagory());
		$smarty->assign('sales_no',"$_SESSION[sales_no]");

		$smarty->assign('total',"$total");
		$smarty->assign('page',"sales");
		$smarty->display('sales/sales.tpl');
	}
} else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access SALES.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
}
else{
	$smarty->assign('page',"Home");
	$smarty->display('index.tpl');
}