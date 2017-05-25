<?php
require_once 'conf/smarty-conf.php';
include 'functions/inventory_functions.php';
include 'functions/quotation_functions.php';
include 'functions/user_functions.php';
include 'functions/navigation_functions.php';

$module_no = 23;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {

	if ($_REQUEST['job']=='barcode'){
		$selected_item=$_POST['barcode'];
		if (!isset($_SESSION['quotation_no'])) {
			$_SESSION['quotation_no']=$quotation_no=get_quotation_no();
		}
		else{
		}
		$quotation_no=$_SESSION['quotation_no'];
		$quotation_info=get_quotation_info_by_quotation_no($quotation_no);

		$info=get_item_info_by_name($selected_item);
		$product_name=$info['product_name'];
        $product_id=$info['product_id'];
		//$stock=get_total_stock($info['product_id']);
		$quantity=get_quantity($product_id, $_SESSION['quotation_no'])+1;

		if(check_added_items($product_id, $_SESSION['quotation_no'])==1){
			$info_for_quotation_has_items=get_product_info_from_quotation_has_items($product_id, $quotation_no);
			$selling_price=$info_for_quotation_has_items['selling_price'];
			$discount=$info_for_quotation_has_items['discount'];
            $quantity=$quantity+1;
			$item_total=($quantity*$selling_price/100)*(100-$discount);
			
				if($_SESSION['edit']==1 && $info_for_quotation_has_items['saved']==1){
					reupdate_inventory($product_id, $info_for_quotation_has_items['quantity'], $stock);
				}
				else{
				}
				update_quotation_item_for_repeative_adding($product_id, $quantity, $item_total);

		}
		else{
			$discount=$info['discount'];
			$selling_price=$info['selling_price'];
						
				add_quotation_item($selected_item, $product_name, $stock, $selling_price, $discount, $_SESSION['quotation_no']);
				//$total_to_ledger=($selling_price/100)*(100-$discount);
                //add_quotation_items_ledger($_SESSION['quotation_no'], $product_id, $total_to_ledger);
                
		}

		$smarty->assign('customer_name',"$quotation_info[customer_name]");
		$smarty->assign('date',"$quotation_info[date]");
		$smarty->assign('remarks',"$quotation_info[remarks]");
		$smarty->assign('quotation_no',"$_SESSION[quotation_no]");
		if($_SESSION['edit']==1){
			$smarty->assign('edit_mode',"on");
			$smarty->assign('prepared_by',"$quotation_info[prepared_by]");
			$smarty->assign('updated_by',"$_SESSION[user_name]");
		}
		else{
			$smarty->assign('prepared_by',"$_SESSION[user_name]");
		}
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('total',get_total_quotation($_SESSION['quotation_no']));
		$smarty->assign('page',"quotation");
		$smarty->display('quotation/quotation.tpl');
	}

	elseif($_REQUEST['job']=='update_item'){

		$product_id=$_REQUEST['product_id'];
		$quantity=$_POST['quantity'];
		$selling_price=$_POST['selling_price'];
		$discount=$_POST['discount'];
		$user_name=$_SESSION['user_name'];
		$item_total=($quantity*$selling_price/100)*(100-$discount);
		//$stock=get_total_stock($_REQUEST['product_id']);
		//$stock = get_branch_stock($product_id);

		$quotation_no=$_SESSION['quotation_no'];
		$quotation_info=get_quotation_info_by_quotation_no($quotation_no);
		$item_info=get_product_info_from_quotation_has_items($product_id, $quotation_no);

		
			if($_SESSION['edit']==1 && $item_info['saved']==1){
				reupdate_inventory($product_id, $item_info['quantity'], $stock);
			}
			else{
			}
			update_quotation_item($product_id, $quantity, $item_total, $selling_price, $discount, $quotation_no, $stock);
			//update_quotation_item_ledger($product_id ,$quotation_no);
		

		$smarty->assign('customer_name',"$quotation_info[customer_name]");
		$smarty->assign('date',"$quotation_info[date]");
		$smarty->assign('remarks',"$quotation_info[remarks]");
		$smarty->assign('quotation_no',"$_SESSION[quotation_no]");
		if($_SESSION['edit']==1){
			$smarty->assign('edit_mode',"on");
			$smarty->assign('prepared_by',"$quotation_info[prepared_by]");
			$smarty->assign('updated_by',"$_SESSION[user_name]");

		}
		else{
			$smarty->assign('prepared_by',"$_SESSION[user_name]");
		}

		$smarty->assign('quotation_no',"$_SESSION[quotation_no]");
		$smarty->assign('prepared_by',"$_SESSION[user_name]");
		$smarty->assign('total',get_total_quotation($_SESSION['quotation_no']));
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('page',"quotation");
		$smarty->display('quotation/quotation.tpl');
	}

	elseif ($_REQUEST['job']=='search'){
		$_SESSION['quotation_no_search']=$_POST['quotation_no_search'];
		$_SESSION['customer_search']=$_POST['customer_search'];

		$smarty->assign('search_mode',"on");
		unset($_SESSION['quotation_no']);
		$smarty->assign('quotation_no_search',"$_SESSION[quotation_no_search]");
		$smarty->assign('customer_search',"$_SESSION[customer_search]");
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('total',"$total");
		$smarty->assign('page',"quotation");
		$smarty->display('quotation/quotation.tpl');
	}
	elseif ($_REQUEST['job']=='edit'){
		$_SESSION['edit']=1;


		$_SESSION['id']=$id=$_REQUEST['id'];
		$info=get_quotation_info($id);
		$_SESSION['quotation_no']=$info['quotation_no'];
		$supplier_name=$info['supplier_name'];
		$remarks=$info['remarks'];
		$prepared_by=$info['prepared_by'];
		$date=$info['date'];

		$smarty->assign('edit_mode',"on");
		$smarty->assign('updated_by',"$_SESSION[user_name]");
		$smarty->assign('total',get_total_quotation($_SESSION['quotation_no']));
		$smarty->assign('parent_catagorys',list_parent_catagory());
		$smarty->assign('quotation_no',"$_SESSION[quotation_no]");
		$smarty->assign('customer_name',"$info[customer_name]");
		$smarty->assign('date',"$info[date]");
		$smarty->assign('remarks',"$info[remarks]");
		$smarty->assign('supplier_search',"$_SESSION[supplier_search]");
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('quotation_no',"$_SESSION[quotation_no]");
		$smarty->assign('prepared_by',"$info[prepared_by]");
		$smarty->assign('page',"quotation");
		$smarty->display('quotation/quotation.tpl');
	}
	elseif ($_REQUEST['job']=='delete_item'){
		$id=$_REQUEST['id'];
		$info=get_product_info_from_quotation_has_items_by_id($id);
		$item_info=get_product_info_from_quotation_has_items($info['product_id'], $_SESSION['quotation_no']);
		$stock=get_total_stock($info['product_id']);

		if($_SESSION['edit']==1 && $item_info['saved']==1){
			reupdate_inventory($info['product_id'], $item_info['quantity'], $stock);
		}
		else{
		}
		cancel_item($id);
		//delete_quotation_items_ledger($id);

		$quotation_no=$_SESSION['quotation_no'];
		$quotation_info=get_quotation_info_by_quotation_no($quotation_no);

		$smarty->assign('customer_name',"$quotation_info[customer_name]");
		$smarty->assign('date',"$quotation_info[date]");
		$smarty->assign('remarks',"$quotation_info[remarks]");
		$smarty->assign('quotation_no',"$_SESSION[quotation_no]");

		if($_SESSION['edit']==1){
			$smarty->assign('edit_mode',"on");
			$smarty->assign('prepared_by',"$quotation_info[prepared_by]");
			$smarty->assign('updated_by',"$_SESSION[user_name]");
		}
		else{
			$smarty->assign('prepared_by',"$_SESSION[user_name]");
		}

		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('quotation_no',"$_SESSION[quotation_no]");
		$smarty->assign('total',get_total_quotation($_SESSION['quotation_no']));
		$smarty->assign('prepared_by',"$_SESSION[user_name]");
		$smarty->assign('page',"quotation");
		$smarty->display('quotation/quotation.tpl');
	}


	elseif($_REQUEST['job']=='quotation'){

		if($_REQUEST['ok']=='Finish the Bill & Print'){
			$date=$_POST['date'];
			$remarks=$_POST['remarks'];
            $discount=$_POST['discount'];
			$customer_name=$_POST['customer_name'];
            $customer_amount=$_POST['customer_amount'];
			$prepared_by=$_POST['prepared_by'];
			$quotation_no=$_POST['quotation_no'];
			$total=get_total_quotation($_SESSION['quotation_no']);
            $total_after_discount= $total-$discount;      
            
            $balance=$customer_amount-$total_after_discount;
			save_quotation($quotation_no, $date, $customer_name, $prepared_by, $remarks,$discount,$customer_amount, $total_after_discount, $total,$balance);
			//add_quotation_ledger($quotation_no);
		}
		else {

			$id=$_SESSION['id'];
			$date=$_POST['date'];
			$remarks=$_POST['remarks'];
            $discount=$_POST['discount'];
			$customer_name=$_POST['customer_name'];
			$prepared_by=$_POST['prepared_by'];
			$updated_by=$_POST['updated_by'];
			$quotation_no=$_POST['quotation_no'];
			$total=get_total_quotation($_SESSION['quotation_no']);
			update_quotation($id, $quotation_no, $date, $customer_name, $prepared_by, $remarks,$discount, $total, $updated_by);
			//update_quotation_ledger($quotation_no);
			unset($_SESSION['edit']);
		}

		$customer_name=$_POST['customer_name'];
		$customer_address=$_POST['customer_address'];
		$customer_tel=$_POST['customer_tel'];
		
		$smarty->assign('customer_name',"$customer_name");
		$smarty->assign('customer_address',"$customer_address");
		$smarty->assign('customer_tel',"$customer_tel");
		
        $_SESSION['print_no']=$_SESSION['quotation_no'];
		unset($_SESSION['quotation_no']);
        $date = date("Y-m-d");

		$smarty->assign('parent_catagorys',list_parent_catagory());
		$smarty->assign('org_name',"$_SESSION[org_name]");
        $smarty->assign('date',"$date");
		$smarty->assign('quotation',"$_SESSION[print_no]");
		$smarty->assign('total',get_total_quotation($_SESSION['quotation_no']));
		$smarty->assign('page',"quotation");
		$smarty->display('quotation/print.tpl');
	}

	elseif ($_REQUEST['job']=='must_new'){
		unset($_SESSION['edit']);
		unset($_SESSION['quotation_no']);
		unset($_SESSION['remarks']);
		unset($_SESSION['prepared_by']);
		unset($_SESSION['updated_by']);
		unset($_SESSION['supplier_name']);
		unset($_SESSION['updated_by']);


		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('parent_catagorys',list_parent_catagory());
		$smarty->assign('page',"quotation");
		$smarty->display('quotation/quotation.tpl');
	}
	
	elseif($_REQUEST['job']=='quotation_page'){
	
		$smarty->assign('page',"Notifications");
		$smarty->display('quotation/quotation.tpl');
	
	}
	
	elseif ($_REQUEST['job']=='select'){
	
		
		$selected_item=$_POST['selected_item'];

		if (!isset($_SESSION['quotation_no'])) {
			$_SESSION['quotation_no']=$quotation_no=get_quotation_no();
		}
		else{
		}
		$quotation_no=$_SESSION['quotation_no'];
		$quotation_info=get_quotation_info_by_quotation_no($quotation_no);

		$info=get_item_info_by_name($selected_item);
		$product_name=$info['product_name'];
        $product_id=$info['product_id'];
		//$stock=get_total_stock($info['product_id']);
		$quantity=get_quantity($product_id, $_SESSION['quotation_no'])+1;

		
		if(check_added_items($product_id, $_SESSION['quotation_no'])==1){
			$info_for_quotation_has_items=get_product_info_from_quotation_has_items($product_id, $quotation_no);
			$selling_price=$info_for_quotation_has_items['selling_price'];
			$discount=$info_for_quotation_has_items['discount'];
            $quantity=$quantity+1;
			$item_total=($quantity*$selling_price/100)*(100-$discount);
			
				if($_SESSION['edit']==1 && $info_for_quotation_has_items['saved']==1){
					reupdate_inventory($product_id, $info_for_quotation_has_items['quantity'], $stock);
				}
				else{
				}
				update_quotation_item_for_repeative_adding($product_id, $quantity, $item_total);

		}
		else{
			$discount=$info['discount'];
			$selling_price=$info['selling_price'];
						
				add_quotation_item($selected_item, $product_name, $stock, $selling_price, $discount, $_SESSION['quotation_no']);
				//$total_to_ledger=($selling_price/100)*(100-$discount);
                //add_quotation_items_ledger($_SESSION['quotation_no'], $product_id, $total_to_ledger);
                
		}

		$smarty->assign('customer_name',"$quotation_info[customer_name]");
		$smarty->assign('date',"$quotation_info[date]");
		$smarty->assign('remarks',"$quotation_info[remarks]");
		$smarty->assign('quotation_no',"$_SESSION[quotation_no]");
		if($_SESSION['edit']==1){
			$smarty->assign('edit_mode',"on");
			$smarty->assign('prepared_by',"$quotation_info[prepared_by]");
			$smarty->assign('updated_by',"$_SESSION[user_name]");
		}
		else{
			$smarty->assign('prepared_by',"$_SESSION[user_name]");
		}
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('total',get_total_quotation($_SESSION['quotation_no']));
		$smarty->assign('page',"quotation");
		$smarty->display('quotation/quotation.tpl');
	
	
	}

	elseif ($_REQUEST['job']=='delete'){
		$module_no = 103;
			if (check_access($module_no, $_SESSION['user_id']) == 1) {
		$id=$_REQUEST['id'];

		$info=get_quotation_info($id);
		$quotation_no_for_delete=$info['quotation_no'];

		calncel_items_for_quotation_no($quotation_no_for_delete);
		cancel_quotation($id);
		//delete_quotation_ledger($quotation_no_for_delete);
		//delete_all_quotation_items_ledger($quotation_no_for_delete);

		$smarty->assign('search_mode',"on");
		unset($_SESSION['quotation_no']);
		$smarty->assign('quotation_no_search',"$_SESSION[quotation_no_search]");
		$smarty->assign('customer_search',"$_SESSION[customer_search]");
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('page',"quotation");
		$smarty->display('quotation/quotation.tpl');
	} else {
				$user_name = $_SESSION['user_name'];
				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('error_report', "on");
				$smarty->assign('error_message', "Dear $user_name, you don't have permission to DELETE a quotation.");
				$smarty->assign('page', "Access Error");
				$smarty->display('user_home/access_error.tpl');
			}
		}


	else {
		unset($_SESSION['edit']);
		unset($_SESSION['quotation_no']);
		unset($_SESSION['remarks']);
		unset($_SESSION['prepared_by']);
		unset($_SESSION['updated_by']);
		unset($_SESSION['supplier_name']);
		unset($_SESSION['updated_by']);
		if(check_non_saved_quotation_order($_SESSION['user_name'])==1){
			$_SESSION['quotation_no']=non_save_quotation_info($_SESSION['user_name']);

			$info=get_quotation_info_by_quotation_no($_SESSION['quotation_no']);
			$customer_name=$info['customer_name'];
			$remarks=$info['remarks'];
			$prepared_by=$info['prepared_by'];
			$date=$info['date'];
			$_SESSION['edit']=1;
			if ($customer_name){
				$smarty->assign('new',"Skip Editing and <a href='quotation.php?job=must_new' style='color: orange; font-size: 20px;'> Create New Perchase Order.</a>");
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
		$total=get_total_quotation($_SESSION['quotation_no']);

		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('parent_catagorys',list_parent_catagory());
		$smarty->assign('quotation_no',"$_SESSION[quotation_no]");

		$smarty->assign('total',"$total");
		$smarty->assign('page',"quotation");
		$smarty->display('quotation/quotation.tpl');
	}
} else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access quotation.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
}
else{
	$smarty->assign('page',"Home");
	$smarty->display('index.tpl');
}