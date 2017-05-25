<?php
require_once 'conf/smarty-conf.php';
include 'functions/modules_functions.php';
include 'functions/employees_functions.php';
include 'functions/user_functions.php';
include 'functions/navigation_functions.php';

$module_no = 24;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "module_form") {
			
			$smarty->assign ( 'page', "Modules" );
			$smarty->display ( 'modules/modules.tpl' );
			
		} elseif ($_REQUEST ['job'] == "save") {
			if ($_REQUEST ['ok'] == 'Update') {
				
				$id = $_SESSION ['id'];
				$info = get_module_info ( $id );
				
				$module_name = $_POST ['module_name'];
				$module_no = $_POST ['module_no'];
				
				update_module ( $id, $module_name, $module_no );
			} else {
				
				$module_name = $_POST ['module_name'];
				$module_no = $_POST ['module_no'];
				
				save_module ( $module_name, $module_no );
			}
			
			$smarty->assign ( 'page', 'Modules' );
			$smarty->display ( 'modules/modules.tpl' );
		} elseif ($_REQUEST ['job'] == "edit") {
			$_SESSION ['id'] = $id = $_REQUEST ['id'];
			$info = get_modules_info_by_id ( $id );
			
			$smarty->assign ( 'module_name', $info ['module_name'] );
			$smarty->assign ( 'module_no', $info ['module_no'] );
			$smarty->assign ( 'edit', 'on' );
			
			$smarty->assign ( 'page', 'Modules' );
			$smarty->display ( 'modules/modules.tpl' );
		} elseif ($_REQUEST ['job'] == "delete") {
			cancel_module ( $_REQUEST ['id'] );
			
			$smarty->assign ( 'page', 'Modules' );
			$smarty->display ( 'modules/modules.tpl' );
		} 

		else {
			$smarty->assign ( 'page', 'Modules' );
			$smarty->display ( 'modules/modules.tpl' );
		}
}
else{
	$smarty->assign ( 'error_report', "on" );
	$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Module Management." );
	$smarty->assign ( 'page', "Access Error" );
	$smarty->display ( 'user_home/access_error.tpl' );
}
}
	

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display('login.tpl');
}