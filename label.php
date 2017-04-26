<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/label_functions.php';

include 'functions/navigation_functions.php';

$module_no = 21;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		if ($_REQUEST['job'] == 'save') {
			if($_REQUEST['ok']=='Save'){
				
				$label = $_POST['label'];
				save_label($label);
				
				$smarty->assign('user_name',"$_SESSION[user_name]");
				$smarty->assign('page', "Label");
				$smarty->display('label/label.tpl');
			}
			
			else {
				$id = $_SESSION['label_id'];
				$label = $_POST['label'];
	
				update_label($id, $label);
				
				$smarty->assign('user_name',"$_SESSION[user_name]");
				$smarty->assign('page', "Label");
				$smarty->display('label/label.tpl');
			}
		}
		elseif ($_REQUEST['job']=='edit'){
			$info=get_label_info($_REQUEST['id']);
			$_SESSION['label_id']=$_REQUEST['id'];
		
			$smarty->assign('label',$info['label']);
			
			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('edit_mode',"on");
			$smarty->assign('page', "Label");
			$smarty->display('label/label.tpl');
		}
		elseif ($_REQUEST['job']=='delete'){
			cancel_label($_REQUEST['id']);
		
			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('page', "Label");
				$smarty->display('label/label.tpl');
		}
		elseif($_REQUEST['job']=='search'){
			$_SESSION['label_search']=$_POST['search'];
		
			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('search',"$_SESSION[label_search]");
			$smarty->assign('search_mode',"on");
			$smarty->assign('page', "Label");
				$smarty->display('label/label.tpl');
		}
		else{
			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('page', "Label");
				$smarty->display('label/label.tpl');
		}
	} 
	else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('user_name', "$_SESSION[user_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access LABEL.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}

}
 else {
	$smarty->assign('error', "<p>Incorrect Login Details!</p>");
	$smarty->display('login.tpl');
}