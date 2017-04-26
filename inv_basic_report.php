<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/inventory_functions.php';
include 'functions/navigation_functions.php';

$module_no = 7;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		
		
		if($_REQUEST['job']=='search'){
			unset($_SESSION['inv_searching']);
			$_SESSION['inv_searching']=1;
			$_SESSION['report_search']=$_POST['search'];

			$smarty->assign('org_name',"$_SESSION[org_name]");
			$smarty->assign('search',"$_SESSION[report_search]");
			$smarty->assign('search_mode',"on");
			$smarty->assign('page', "Inventory Basic Report");
			$smarty->display('inv_reports/inv_basic_report.tpl');
		}
	elseif($_REQUEST['job']=='select_fields'){
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('page', "Print Report");
		$smarty->display('inv_reports/select_fields.tpl');
	}
	elseif($_REQUEST['job']=='custom'){
		$user_name = $_SESSION['user_name'];
		
		$_SESSION['product_name']=$_POST['product_name'];
		$_SESSION['product_id']=$_POST['product_id'];
		$_SESSION['product_catagory']=$_POST['product_catagory'];
		$_SESSION['stock']=$_POST['stock'];
		$_SESSION['sold']=$_POST['sold'];
		$_SESSION['selling_price']=$_POST['selling_price'];
		$_SESSION['buying_price']=$_POST['buying_price'];
		$_SESSION['stock_value']=$_POST['stock_value'];
		$_SESSION['discount']=$_POST['discount'];
		$_SESSION['puchased_date']=$_POST['puchased_date'];
		
		
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('page', "Print Report");
		$smarty->display('inv_reports/inv_custom_report.tpl');
	}
	
	elseif($_REQUEST['job']=='custom_print'){
		$user_name = $_SESSION['user_name'];
		
		$today = date("Y-m-d");
	if ($_SESSION['inv_searching']==1){
			$smarty->assign('search_mode',"on");
		}
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('today', "$today");
		$smarty->assign('page', "Print Report");
		$smarty->display('inv_reports/custom_inv_print.tpl');
	}
	
	elseif($_REQUEST['job']=='print'){
		$user_name = $_SESSION['user_name'];
		
		$today = date("Y-m-d");
	if ($_SESSION['inv_searching']==1){
			$smarty->assign('search_mode',"on");
		}
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('today', "$today");
		$smarty->assign('page', "Print Report");
		$smarty->display('inv_reports/basic_inv_print.tpl');
	}
	else{

		unset($_SESSION['product_name']);
		unset($_SESSION['product_id']);
		unset($_SESSION['product_catagory']);
		unset($_SESSION['stock']);
		unset($_SESSION['sold']);
		unset($_SESSION['selling_price']);
		unset($_SESSION['buying_price']);
		unset($_SESSION['stock_value']);
		unset($_SESSION['discount']);
		unset($_SESSION['puchased_date']);
		unset($_SESSION['inv_searching']);
		
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Inventory Basic Report");
			$smarty->display('inv_reports/inv_basic_report.tpl');
		}
	} 
	
	else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to VIEW REPORTS.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
} else {
	$smarty->assign('page', "Home");
	$smarty->display('index.tpl');
}