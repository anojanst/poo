<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/inventory_functions.php';

if ($_SESSION['login']==1){
	if($_REQUEST['job']=='add'){
		if ($_REQUEST['ok']=='Update'){
			$id=$_SESSION['id'];
			$catagory=$_POST['catagory'];
			$parent_catagory=$_POST['parent_catagory'];

			update_catagory($id, $catagory, $parent_catagory);

			$smarty->assign('parent_catagorys',list_parent_catagory());
			$smarty->assign('org_name',"$_SESSION[org_name]");
			$smarty->assign('page',"Inventory");
			$smarty->display('inventory/inventory.tpl');

		}
		else{

			$catagory=$_POST['catagory'];
			$parent_catagory=$_POST['parent_catagory'];

			save_catagory($catagory, $parent_catagory);

			$smarty->assign('parent_catagorys',list_parent_catagory());
			$smarty->assign('org_name',"$_SESSION[org_name]");
			$smarty->assign('page',"Inventory");
			$smarty->display('inventory/inventory.tpl');
		}
	}
	elseif ($_REQUEST['job']=='edit'){
		$info=get_catagory_info($_REQUEST['id']);
		$_SESSION['id']=$_REQUEST['id'];

		$smarty->assign('catagory',$info['catagory']);
		$smarty->assign('parent_catagory',$info['parent_catagory']);

		$smarty->assign('parent_catagorys',list_parent_catagory());
		$smarty->assign('edit',"Catagory");
		$smarty->assign('edit_mode',"on");
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('page',"Inventory");
		$smarty->display('inventory/inventory.tpl');
	}
	elseif ($_REQUEST['job']=='delete'){
		$module_no= 102;
		if (check_access($module_no, $_SESSION['user_id'])==1){
			$info=get_catagory_info($_REQUEST['id']);
			$catagory=$info['catagory'];

			if(check_parent_catagory($catagory)==1){
					
				$smarty->assign('error_report',"on");
				$smarty->assign('error_message',"Delete process canceled. Catagory '$catagory' have sub catagory.");
			}

			else{
				if (check_product($catagory)==1){
					$smarty->assign('error_report',"on");
					$smarty->assign('error_message',"Delete process canceled. Catagory '$catagory' have Products.");
				}
				else{
					cancel_catagory($_REQUEST['id']);
				}
			}

			$smarty->assign('parent_catagorys',list_parent_catagory());
			$smarty->assign('org_name',"$_SESSION[org_name]");
			$smarty->assign('page',"Inventory");
			$smarty->display('inventory/inventory.tpl');
		}
		else{
			$user_name=$_SESSION['user_name'];
			$smarty->assign('org_name',"$_SESSION[org_name]");
			$smarty->assign('error_report',"on");
			$smarty->assign('error_message',"Dear $user_name, you don't have permission to access DELETE a Catagory.");
			$smarty->assign('page',"Access Error");
			$smarty->display('user_home/access_error.tpl');
		}
	}
	else{
		$smarty->assign('parent_catagorys',list_parent_catagory());
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('page',"Inventory");
		$smarty->display('inventory/inventory.tpl');
	}
}
else{
	$smarty->assign('error',"Incorrect Login Details!");
	$smarty->display('login.tpl');
}