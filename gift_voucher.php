
<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/gift_voucher_functions.php';
include 'functions/employees_functions.php';
include 'functions/navigation_functions.php';
include 'functions/inventory_functions.php';
include 'functions/notifications_functions.php';

$module_no = 10;
if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		
		if ($_REQUEST['job']=='gift_voucher'){

			$smarty->assign('page', "gift_voucher");
			$smarty->display('gift_voucher/gift_voucher.tpl');
					
		
		}
		
		
		if ($_REQUEST['job'] == 'save') {
			if($_REQUEST['ok']=='Save'){
				
				$voucher_no = $_POST['voucher_no'];
				$voucher_amount = $_POST['voucher_amount'];
				$address = addslashes($_POST['address']);
				$phone_no = $_POST['phone_no'];
				$customer_name = $_POST['customer_name'];
	
				
				save_voucher($voucher_no, $voucher_amount, $customer_name, $address, $phone_no);
				$smarty->assign('user_name',$_SESSION['user_name']);
				$smarty->assign('page', "gift_voucher");
				$smarty->display('gift_voucher/gift_voucher.tpl');
			}
			
			else {
				$id=$_SESSION['id'];  
				$voucher_no = $_POST['voucher_no'];
				$voucher_amount = $_POST['voucher_amount'];
				$address = addslashes($_POST['address']);
				$phone_no = $_POST['phone_no'];
				$customer_name = $_POST['customer_name'];

				 update_voucher($id, $voucher_no, $voucher_amount, $customer_name, $address, $phone_no);
				$smarty->assign('user_name',$_SESSION['user_name']);
				$smarty->assign('page', "gift_voucher");
				$smarty->display('gift_voucher/gift_voucher.tpl');
			}
		}
	

        
        elseif ($_REQUEST['job']=='delete'){
             cancel_vocher($_REQUEST['id']);
			 
			$smarty->assign('page', "gift_voucher");
			$smarty->display('gift_voucher/gift_voucher.tpl');;
		}
        

		 
		elseif ($_REQUEST['job']=='edit'){
			
			$info=get_voucher_info($_REQUEST['id']);
			$_SESSION['id']=$_REQUEST['id'];
		
			$smarty->assign('voucher_no',$info['voucher_no']);
			$smarty->assign('voucher_amount',$info['voucher_amount']);
			$smarty->assign('address',$info['address']);
			$smarty->assign('phone_no',$info['phone_no']);
			$smarty->assign('customer_name',$info['customer_name']);
			
			$smarty->assign('edit',"on");
		
			$smarty->assign('page', "gift_voucher");
			$smarty->display('gift_voucher/gift_voucher.tpl');
		}
		
	} else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access Gift Voucher.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
} else {
	$smarty->assign('error', "Incorrect Login Details!");
	$smarty->display('login.tpl');
}