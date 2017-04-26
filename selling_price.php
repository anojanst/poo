<?php
require_once 'conf/smarty-conf.php';
include 'functions/inventory_functions.php';
$module_no = 3;

if ($_SESSION['login'] == 1) {

	if($_REQUEST['job']=='add_selling_price'){

		$product_id=$_REQUEST['product_id'];
		$selling_price=$_POST['selling_price'];
		$user_name=$_SESSION['user_name'];
	
		update_selling_price($product_id, $selling_price, $user_name);

		$smarty->assign('prepared_by',"$_SESSION[user_name]");
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('page',"selling pice");
		$smarty->display('inventory/selling_price.tpl');
	}


	
	else {
		
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('page',"selling pice");
		$smarty->display('inventory/selling_price.tpl');
	}

}
else{
	$smarty->assign('page',"Home");
	$smarty->display('index.tpl');
}