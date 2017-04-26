<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/inventory_functions.php';

$module_no = 7;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		if($_REQUEST['job']=='search'){
			
			$_SESSION['product_name']=$_POST['product_name'];
			$_SESSION['supplier']=$_POST['supplier'];
			$_SESSION['qty_less_than']=$_POST['qty_less_than'];
			$_SESSION['qty_more_than']=$_POST['qty_more_than'];
			$_SESSION['bp_less_than']=$_POST['bp_less_than'];
			$_SESSION['bp_more_than']=$_POST['bp_more_than'];
			$_SESSION['sp_less_than']=$_POST['sp_less_than'];
			$_SESSION['sp_more_than']=$_POST['sp_more_than'];
			$_SESSION['purchased_after']=$_POST['purchased_after'];
			$_SESSION['purchased_before']=$_POST['purchased_before'];

			$smarty->assign('org_name',"$_SESSION[org_name]");
			$smarty->assign('product_name',"$_SESSION[product_name]");
			$smarty->assign('supplier',"$_SESSION[supplier]");
			$smarty->assign('qty_less_than',"$_SESSION[qty_less_than]");
			$smarty->assign('qty_more_than',"$_SESSION[qty_more_than]");
			$smarty->assign('bp_less_than',"$_SESSION[bp_less_than]");
			$smarty->assign('bp_more_than',"$_SESSION[bp_more_than]");
			$smarty->assign('sp_less_than',"$_SESSION[sp_less_than]");
			$smarty->assign('sp_more_than',"$_SESSION[sp_more_than]");
			$smarty->assign('purchased_after',"$_SESSION[purchased_after]");
			$smarty->assign('purchased_before',"$_SESSION[purchased_before]");
			$smarty->assign('search_mode',"on");
			$smarty->assign('page', "Sales Full Report");
			$smarty->display('sales_reports/sales_full_report.tpl');
		}
		elseif($_REQUEST['job']=='product_on_demand'){
			
			$smarty->assign('demand_report',"on");
			$smarty->assign('org_name',"$_SESSION[org_name]");
			$smarty->assign('page', "Sales Full Report");
			$smarty->display('sales_reports/sales_full_report.tpl');
		}
		elseif($_REQUEST['job']=='product_with_profit'){
			
			$smarty->assign('product_profit_report',"on");
			$smarty->assign('org_name',"$_SESSION[org_name]");
			$smarty->assign('page', "Sales Full Report");
			$smarty->display('sales_reports/sales_full_report.tpl');
		}
		elseif($_REQUEST['job']=='product_with_loss'){
			
			$smarty->assign('product_loss_report',"on");
			$smarty->assign('org_name',"$_SESSION[org_name]");
			$smarty->assign('page', "Sales Full Report");
			$smarty->display('sales_reports/sales_full_report.tpl');
		}
		elseif($_REQUEST['job']=='recently_purchased'){
			
			$smarty->assign('recent_purchase',"on");
			$smarty->assign('org_name',"$_SESSION[org_name]");
			$smarty->assign('page', "Sales Full Report");
			$smarty->display('sales_reports/sales_full_report.tpl');
		}
		elseif($_REQUEST['job']=='out_of_stock'){
			
			$smarty->assign('out_of_stock',"on");
			$smarty->assign('org_name',"$_SESSION[org_name]");
			$smarty->assign('page', "Sales Full Report");
			$smarty->display('sales_reports/sales_full_report.tpl');
		}
		elseif($_REQUEST['job']=='without_sales'){
			
			$smarty->assign('without_sales',"on");
			$smarty->assign('org_name',"$_SESSION[org_name]");
			$smarty->assign('page', "Sales Full Report");
			$smarty->display('sales_reports/sales_full_report.tpl');
		}
		elseif($_REQUEST['job']=='catagory_list'){
			
			
			//update_temp_catagory();
			$smarty->assign('catagory_list',"on");
			
			$smarty->assign('org_name',"$_SESSION[org_name]");
			$smarty->assign('page', "Sales Full Report");
			$smarty->display('sales_reports/sales_full_report.tpl');
		}
		elseif($_REQUEST['job']=='list_inventory_by_cat'){
			$_SESSION['category']=$_REQUEST['cat'];
			$smarty->assign('list_inventory_by_cat',"on");
			
			$smarty->assign('catagory_list',"on");
				
			$smarty->assign('org_name',"$_SESSION[org_name]");
			$smarty->assign('page', "Sales Full Report");
			$smarty->display('sales_reports/sales_full_report.tpl');
		}
		else{
		
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Sales Full Report");
			$smarty->display('sales_reports/sales_full_report.tpl');
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
}
else {
	$smarty->assign('page', "Home");
	$smarty->display('index.tpl');
}