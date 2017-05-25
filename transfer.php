
<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/transfer_functions.php';
include 'functions/employees_functions.php';
include 'functions/navigation_functions.php';
include 'functions/inventory_functions.php';
include 'functions/notifications_functions.php';

$module_no = 10;
if ($_SESSION['login'] == 1) {
	if (1 == 1) {
		
		if ($_REQUEST['job']=='barcode'){
		
			$selected_item=$_POST['barcode'];
		
		        if (!isset($_SESSION['transfer_no'])) {
                    $_SESSION['transfer_no']=$transfer_no=get_transfer_no();
                }
            	else{
                }
		
                
                $info=get_item_info_by_barcode($selected_item);
                
 				$transfer_no=$_SESSION['transfer_no'];
				$product_name = $info['product_name'];
				$product_id=$info['product_id'];
				$quantity = $_POST['quantity'];
				
                
				$stock_info=get_stock_by_branch_product_id($product_id, $_SESSION['branch']);
				$stock=$stock_info['stock'];
				$branch=$_SESSION['branch'];

				if (check_product_name($product_name)==1){
					
					if($stock>$quantity){
						save_transfer_has_items($transfer_no, $product_id, $product_name, $quantity);
					}else{
						$ref_type='Transfer';
						save_transfer_has_items($transfer_no, $product_id, $product_name, $quantity);
						
						save_notification($product_id, $product_name, $branch, $quantity, $transfer_no, $ref_type);
						
						$smarty->assign('error_report',"on");
						$smarty->assign('error_message',"Not Enough Stock.");
					}
				}else{
						$smarty->assign('stock_warning',"on");
					$smarty->assign('stock_warning_message',"Stock Mismatch Warning.");
				
				}
                $smarty->assign('transfer_no',"$_SESSION[transfer_no]");
                $smarty->assign('branch',"$_SESSION[branch]");
                $smarty->assign ( 'to_branch_names', list_branch() );
				$smarty->assign('page', "transfer");
				$smarty->display('transfer/transfer.tpl');
					
		
		}
		
		
		else if ($_REQUEST['job'] == 'add') {
            
				$product_name = $_POST['product_name'];
				$quantity = $_POST['quantity'];
				$branch = $_POST['branch'];
				$to_branch = $_SESSION['branch'];
                
                $info=get_product_id_by_product_name($product_name);
                
                $product_id=$info['product_id'];
                
				save_transfer($product_id, $product_name, $quantity, $branch, $to_branch);
                update_stock($product_id, $branch, $quantity );
                $smarty->assign ( 'to_branch_names', list_branch() );
				$smarty->assign('page', "transfer");
				$smarty->display('transfer/transfer.tpl');
          
		}
	
     elseif ($_REQUEST['job'] == 'add_transfer') {
            	
                if (!isset($_SESSION['transfer_no'])) {
                    $_SESSION['transfer_no']=$transfer_no=get_transfer_no();
                }
            	else{
                }
                

                $transfer_no=$_SESSION['transfer_no'];
				$product_name = $_POST['product_name'];
				$quantity = $_POST['quantity'];
                
                $info=get_product_id_by_product_name($product_name);
                
                $product_id=$info['product_id'];
                
				$stock_info=get_stock_by_branch_product_id($product_id, $_SESSION['branch']);
				$stock=$stock_info['stock'];
				$branch=$_SESSION['branch'];

				if (check_product_name($product_name)==1){
					
					if($stock>$quantity){
						save_transfer_has_items($transfer_no, $product_id, $product_name, $quantity);
					}else{
						$ref_type='Transfer';
						save_transfer_has_items($transfer_no, $product_id, $product_name, $quantity);
						
						save_notification($product_id, $product_name, $branch, $quantity, $transfer_no, $ref_type);
						
						$smarty->assign('error_report',"on");
						$smarty->assign('error_message',"Not Enough Stock.");
					}
				}else{
						$smarty->assign('stock_warning',"on");
					$smarty->assign('stock_warning_message',"Stock Mismatch Warning.");
				
				}
                $smarty->assign('transfer_no',"$_SESSION[transfer_no]");
                $smarty->assign('branch',"$_SESSION[branch]");
                $smarty->assign ( 'to_branch_names', list_branch() );
				$smarty->assign('page', "transfer");
				$smarty->display('transfer/transfer.tpl');
          
		}
        
        elseif ($_REQUEST['job']=='delete_item'){
                $id=$_REQUEST['id'];           
                remove_transfer_has_items($id);
                
                $smarty->assign ( 'to_branch_names', list_branch() );
                $smarty->assign('transfer_no',"$_SESSION[transfer_no]");
                $smarty->assign('branch',"$_SESSION[branch]");
				$smarty->assign('page', "transfer");
				$smarty->display('transfer/transfer.tpl');
		}
        
        elseif($_REQUEST['job']=='transfer'){

                if($_REQUEST['ok']=='Finish the transfer'){

                    $transfer_no=$_POST['transfer_no'];
                    $branch = $_POST['branch'];
                    $to_branch = $_POST['to_branch'];
                    $quantity = $_POST['quantity'];
                    $info=get_product_id_by_product_name($product_name);
                
                    $product_id=$info['product_id'];
                    save_transfer($transfer_no, $branch, $to_branch);
					update_stock($to_branch, $transfer_no );
					
                }
                else {
        
                }

		unset($_SESSION['transfer_no']);
        $date = date("Y-m-d");

        $smarty->assign ( 'to_branch_names', list_branch() );
		$smarty->assign('transfer_no',"$_SESSION[transfer_no]");
		$smarty->assign('branch',"$_SESSION[branch]");
		$smarty->assign('page', "transfer");
		$smarty->display('transfer/transfer.tpl');
	}
	
		 elseif ($_REQUEST['job']=='to_store'){

				$smarty->assign('page', "transfer");
				$smarty->display('transfer/to_store.tpl');
		}
		
		 elseif ($_REQUEST['job']=='from_store'){

				$smarty->assign('page', "transfer");
				$smarty->display('transfer/from_store.tpl');
		}
    
		elseif($_REQUEST['job']=='to_store_search'){
				unset($_SESSION['searching']);
				$_SESSION['searching']=1;
	
			//	$_SESSION['to_store']=$_POST['to_store'];
				$_SESSION['to_branch']=$_POST['to_branch'];
				$_SESSION['from_date']=$_POST['from_date'];
				$_SESSION['to_date']=$_POST['to_date'];
	
			//	$smarty->assign('org_name',"$_SESSION[org_name]");
			//	$smarty->assign('to_store',"$_SESSION[to_store]");
				$smarty->assign('to_branch',"$_SESSION[to_branch]");
				$smarty->assign('from_date',"$_SESSION[from_date]");
				$smarty->assign('to_date',"$_SESSION[to_date]");
				$smarty->assign('search_mode',"on");
				$smarty->assign('page', "transfer");
				$smarty->display('transfer/to_store.tpl');
		}
		
		elseif($_REQUEST['job']=='from_store_search'){
				unset($_SESSION['searching']);
				$_SESSION['searching']=1;
	
			//	$_SESSION['to_store']=$_POST['to_store'];
				$_SESSION['from_branch']=$_POST['from_branch'];
				$_SESSION['from_date']=$_POST['from_date'];
				$_SESSION['to_date']=$_POST['to_date'];
	
			//	$smarty->assign('org_name',"$_SESSION[org_name]");
			//	$smarty->assign('to_store',"$_SESSION[to_store]");
				$smarty->assign('to_branch',"$_SESSION[to_branch]");
				$smarty->assign('from_date',"$_SESSION[from_date]");
				$smarty->assign('from_branch',"$_SESSION[from_branch]");
				$smarty->assign('search_mode',"on");
				$smarty->assign('page', "transfer");
				$smarty->display('transfer/from_store.tpl');
		}
		
		elseif($_REQUEST['job']=='update_item'){
		
				$product_id=$_REQUEST['product_id'];
				
				$info=get_item_info_by_name($product_id);
                
 				$transfer_no=$_SESSION['transfer_no'];
				$product_name = $info['product_name'];
				
				$quantity = $_POST['quantity'];
				
                
				$stock_info=get_stock_by_branch_product_id($product_id, $_SESSION['branch']);
				$stock=$stock_info['stock'];
				$branch=$_SESSION['branch'];

				if (check_product_name($product_name)==1){
					
					if($stock>$quantity){
						//save_transfer_has_items($transfer_no, $product_id, $product_name, $quantity);
						update_transfer_has_items($transfer_no, $product_id, $product_name, $quantity);
					}else{
						$ref_type='Transfer';
						update_transfer_has_items($transfer_no, $product_id, $product_name, $quantity);
						
						save_notification($product_id, $product_name, $branch, $quantity, $transfer_no, $ref_type);
						
						$smarty->assign('error_report',"on");
						$smarty->assign('error_message',"Not Enough Stock.");
					}
				}else{
					$smarty->assign('stock_warning',"on");
					$smarty->assign('stock_warning_message',"Stock Mismatch Warning.");
				
				}
                $smarty->assign('transfer_no',"$_SESSION[transfer_no]");
                $smarty->assign('branch',"$_SESSION[branch]");
                $smarty->assign ( 'to_branch_names', list_branch() );
				$smarty->assign('page', "transfer");
				$smarty->display('transfer/transfer.tpl');
		}
		
		elseif ($_REQUEST['job']=='must_new'){
			
			unset($_SESSION['edit']);
			unset($_SESSION['transfer_no']);
		
			$smarty->assign('page', "transfer");
			$smarty->display('transfer/transfer.tpl');
		}
		
			
	else {
            $smarty->assign ( 'to_branch_names', list_branch() );
			$smarty->assign('page', "transfer");
			$smarty->display('transfer/transfer.tpl');
        }
	} else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access TRANSFER.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
} else {
	$smarty->assign('error', "Incorrect Login Details!");
	$smarty->display('login.tpl');
}