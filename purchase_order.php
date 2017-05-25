<?php
require_once 'conf/smarty-conf.php';

include 'functions/purchase_order_functions.php';
include 'functions/inventory_functions.php';
include 'functions/sales_functions.php';
include 'functions/ledger_functions.php';
include 'functions/user_functions.php';
include 'functions/navigation_functions.php';
include 'functions/multiple_stock_functions.php';

$module_no = 4;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		if ($_REQUEST['job']=='barcode'){
            $selected_item=$_POST['barcode'];

                if (!isset($_SESSION['purchase_order_no'])) {
                    $_SESSION['purchase_order_no']=$sales_no=get_purchase_no();
                }
                else{
                }

                $purchase_order_no=$_SESSION['purchase_order_no'];
                $purchase_info=get_purchase_order_info_by_purchase_no($purchase_order_no);
                $info=get_item_info_by_barcode($selected_item) ;

				$product_name=$info['product_name'];
				$product_id=$info['product_id'];
				//$stock=get_total_stock($info['product_id']);
				$stock = get_branch_stock($product_id);
				$quantity=get_purchase_quantity($product_id, $_SESSION['purchase_order_no']);
				$multiple_info=get_multiple_stock_by_product_id($product_id);

            if($product_id){
                if(check_purchase_added_items($product_id, $_SESSION['purchase_order_no'])==1){
                    $info_for_purchase_has_items=get_product_info_from_purchase_has_items($product_id, $purchase_order_no);
                    $buying_price=$info_for_purchase_has_items['buying_price'];
                    $discount=$info_for_purchase_has_items['discount'];
                    $quantity=$quantity+1;
                    $item_total=($quantity*$buying_price/100)*(100-$discount);

                        update_purchase_item_for_repeative_adding($product_id, $quantity, $item_total);
                        //update_sales_item_ledger($product_id ,$_SESSION['sales_no']);
                    
                }
                else{
                    $discount=$info['discount'];
                    $buying_price=$info['buying_price'];
					$quantity=1;
                   save_item($product_id, $product_name, $quantity, $buying_price, $catagory, $product_description, $measure_type, $purchase_order_no, $user_name);
				   $total_to_ledger=($selling_price/100)*(100-$discount);
                  //  add_sales_items_ledger($_SESSION['sales_no'], $product_id, $total_to_ledger);


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


                $total_without_discount= get_total_without_discount($_SESSION['sales_no']);
                $sales_total= get_total_sales($_SESSION['sales_no']);

                if($total_without_discount==$sales_total){
                    $smarty->assign('discount_display',"on");
                }else{
                    $smarty->assign('discount_display',"off");
                }


                $smarty->assign('org_name',"$_SESSION[org_name]");
                $smarty->assign('total',get_total_sales($_SESSION['sales_no']));
               	$smarty->assign('page', "Purchase Order");
				$smarty->display('purchase_order/purchase_order.tpl');

            }else{
                $smarty->assign('stock_warning',"on");
                $smarty->assign('stock_warning_message',"Stock Mismatch Warning.");

                $smarty->assign('page', "Purchase Order");
				$smarty->display('purchase_order/purchase_order.tpl');
            }
      
		}
        elseif ($_REQUEST['job']=='select'){
            $selected_item=$_POST['selected_item'];
             if (!isset($_SESSION['purchase_order_no'])) {
                    $_SESSION['purchase_order_no']=$sales_no=get_purchase_no();
                }
                else{
                }

             $purchase_order_no=$_SESSION['purchase_order_no'];
                $purchase_info=get_purchase_order_info_by_purchase_no($purchase_order_no);
                $info=get_item_info_by_selected_name($selected_item) ;

				$product_name=$info['product_name'];
				$product_id=$info['product_id'];
				//$stock=get_total_stock($info['product_id']);
				$stock = get_branch_stock($product_id);
				$quantity=get_purchase_quantity($product_id, $_SESSION['purchase_order_no']);
				$multiple_info=get_multiple_stock_by_product_id($product_id);

            if($product_id){
                if(check_purchase_added_items($product_id, $_SESSION['purchase_order_no'])==1){
                    $info_for_purchase_has_items=get_product_info_from_purchase_has_items($product_id, $purchase_order_no);
                    $buying_price=$info_for_purchase_has_items['buying_price'];
                    $discount=$info_for_purchase_has_items['discount'];
                    $quantity=$quantity+1;
                    $item_total=($quantity*$buying_price/100)*(100-$discount);

                        update_purchase_item_for_repeative_adding($product_id, $quantity, $item_total);
                        //update_sales_item_ledger($product_id ,$_SESSION['sales_no']);
                    
                }
                else{
                    $discount=$info['discount'];
                    $buying_price=$info['buying_price'];
					$quantity=1;
                   save_item($product_id, $product_name, $quantity, $buying_price, $catagory, $product_description, $measure_type, $purchase_order_no, $user_name);
				   $total_to_ledger=($selling_price/100)*(100-$discount);
                  //  add_sales_items_ledger($_SESSION['sales_no'], $product_id, $total_to_ledger);


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


                $total_without_discount= get_total_without_discount($_SESSION['sales_no']);
                $sales_total= get_total_sales($_SESSION['sales_no']);

                if($total_without_discount==$sales_total){
                    $smarty->assign('discount_display',"on");
                }else{
                    $smarty->assign('discount_display',"off");
                }


                $smarty->assign('org_name',"$_SESSION[org_name]");
                $smarty->assign('total',get_total_sales($_SESSION['sales_no']));
               	$smarty->assign('page', "Purchase Order");
				$smarty->display('purchase_order/purchase_order.tpl');

            }else{
                $smarty->assign('stock_warning',"on");
                $smarty->assign('stock_warning_message',"Stock Mismatch Warning.");

                $smarty->assign('page', "Purchase Order");
				$smarty->display('purchase_order/purchase_order.tpl');
            }
      
        }
		
		
		elseif($_REQUEST['job']=='update_item'){
            $id=$_REQUEST['id'];
            $product_id=$_REQUEST['product_id'];
            $quantity=$_POST['quantity'];
            $buying_price=$_POST['buying_price'];
            $discount=$_POST['discount'];
            if($discount<100){
                $user_name=$_SESSION['user_name'];
                $item_total=($quantity*$buying_price/100)*(100-$discount);
                //$stock=get_total_stock($_REQUEST['product_id']);
               // $stock = get_branch_stock($product_id);
                $price=$buying_price*$quantity;
                $purchase_order_no=$_SESSION['purchase_order_no'];
                $sales_info=get_purchase_order_info_by_purchase_no($purchase_order_no);
                $item_info=get_product_info_from_purchase_has_items($product_id, $purchase_order_no);


               update_purchase_item($id, $product_id, $quantity, $item_total, $buying_price, $discount, $purchase_order_no); // update_sales_item_ledger($product_id ,$sales_no);


                $smarty->assign('customer_name',"$sales_info[customer_name]");
                $smarty->assign('date',"$sales_info[date]");
                $smarty->assign('remarks',"$sales_info[remarks]");
                $smarty->assign('sales_no',"$_SESSION[sales_no]");


                $total_without_discount= get_total_without_discount($_SESSION['sales_no']);
                $sales_total= get_total_sales($_SESSION['sales_no']);

                if($total_without_discount==$sales_total){
                    $smarty->assign('discount_display',"on");
                }else{
                    $smarty->assign('discount_display',"off");
                }


                $smarty->assign('sales_no',"$_SESSION[sales_no]");
                $smarty->assign('prepared_by',"$_SESSION[user_name]");
                $smarty->assign('total',get_total_sales($_SESSION['sales_no']));
                $smarty->assign('org_name',"$_SESSION[org_name]");
               $smarty->assign('page', "Purchase Order");
				$smarty->display('purchase_order/purchase_order.tpl');
            }
            else{
                $user_name = $_SESSION['user_name'];
                $smarty->assign('org_name', "$_SESSION[org_name]");
                $smarty->assign('pay_error', "on");
                $smarty->assign('sales_no',"$_SESSION[sales_no]");
                $smarty->assign('total',get_total_sales($_SESSION['sales_no']));
                $smarty->assign('prepared_by',"$_SESSION[user_name]");
                $smarty->assign('pay_error_msg', "Dear $user_name, customer paying amount or Discount can't be morethan 100%");
                $smarty->assign('page', "Purchase Order");
				$smarty->display('purchase_order/purchase_order.tpl');
            }
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

            $total_without_discount= get_total_without_discount($_SESSION['sales_no']);
            $sales_total= get_total_sales($_SESSION['sales_no']);

            if($total_without_discount==$sales_total){
                $smarty->assign('discount_display',"on");
            }else{
                $smarty->assign('discount_display',"off");
            }

            $smarty->assign('prepared_by',"$_SESSION[user_name]");
            $smarty->assign('page',"sales");
            $smarty->display('sales/sales.tpl');
        }
		
		elseif ($_REQUEST['job'] == 'purchase_item') {

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

		 else {
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