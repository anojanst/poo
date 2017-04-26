<?php
require_once 'conf/smarty-conf.php';
include 'functions/customer_functions.php';

include 'functions/navigation_functions.php';

if ($_SESSION['login']==1){

	if ($_REQUEST['job']=="customer_form"){
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('page',"Customer");
		$smarty->display('customer/customer.tpl');
	}

	elseif ($_REQUEST['job']=="add"){
		if ($_REQUEST['ok']=='Update') {
			$id=$_SESSION['id'];
			$info=get_customer_info_by_id($id);

			$customer_name=$_POST['customer_name'];
			$address=addslashes($_POST['address']);
			$contact_person=$_POST['contact_person'];
			$telephone=$_POST['telephone'];
			$fax=$_POST['fax'];
			$email=$_POST['email'];
			$customer_status=$_POST['customer_status'];
			$opening_balance=$_POST['opening_balance'];
			$opening_balance_date=$_POST['opening_balance_date'];
			$credit_limit=$_POST['credit_limit'];
			$credit_period=$_POST['credit_period'];

			update_customer($id, $customer_name, $address, $contact_person, $telephone, $fax, $email, $customer_status, $opening_balance, $opening_balance_date, $credit_limit, $credit_period);
		}
		else{
			$customer_name=$_POST['customer_name'];
			$address=addslashes($_POST['address']);
			$contact_person=$_POST['contact_person'];
			$telephone=$_POST['telephone'];
			$fax=$_POST['fax'];
			$email=$_POST['email'];
			$customer_status=$_POST['customer_status'];
			$opening_balance=$_POST['opening_balance'];
			$opening_balance_date=$_POST['opening_balance_date'];
			$credit_limit=$_POST['credit_limit'];
			$credit_period=$_POST['credit_period'];

			save_customer($customer_name, $address, $contact_person, $telephone, $fax, $email, $customer_status, $opening_balance, $opening_balance_date, $credit_limit, $credit_period);
		}

		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('page',"Customer");
		$smarty->display('customer/customer.tpl');
	}
	elseif ($_REQUEST['job']=="edit"){
		$_SESSION['id']=$id=$_REQUEST['id'];
		$info=get_customer_info_by_id($id);

		$smarty->assign('customer_name',$info['customer_name']);
		$smarty->assign('address',$info['address']);
		$smarty->assign('telephone',$info['telephone']);
		$smarty->assign('fax',$info['fax']);
		$smarty->assign('email',$info['email']);
		$smarty->assign('contact_person',$info['contact_person']);
		$smarty->assign('customer_status',$info['customer_status']);
		$smarty->assign('opening_balance',$info['opening_balance']);
		$smarty->assign('opening_balance_date',$info['opening_balance_date']);
		$smarty->assign('credit_limit',$info['credit_limit']);
		$smarty->assign('credit_period',$info['credit_period']);

		$smarty->assign('edit_mode','on');
		$smarty->assign('edit','Customer');
		$smarty->assign('page',"Customer");
		$smarty->display('customer/customer.tpl');
	}
	elseif($_REQUEST['job']=='search'){

		$_SESSION['search']=$_POST['search'];

		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('search',"$_SESSION[search]");
		$smarty->assign('search_mode',"on");
		$smarty->assign('page',"Customer");
		$smarty->display('customer/customer.tpl');
	}
	elseif ($_REQUEST['job']=="delete"){
		cancel_customer($_REQUEST['id']);

		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('page',"Customer");
		$smarty->display('customer/customer.tpl');
	}
	else{
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('page',"Customer");
		$smarty->display('customer/customer.tpl');
	}
}
else{
	$smarty->assign('page',"Home");
	$smarty->display('index.tpl');
}