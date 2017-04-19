<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/publication_functions.php';

$module_no = 20;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		if ($_REQUEST['job'] == 'save') {
			if($_REQUEST['ok']=='Save'){
				
				$publication = $_POST['publication'];
				$publication_id = $_POST['publication_id'];
				$description = $_POST['description'];
	
				save_publication($publication, $publication_id, $description);
				
				$smarty->assign('user_name',"$_SESSION[user_name]");
				$smarty->assign('page', "Publication");
				$smarty->display('publication/publication.tpl');
			}
			
			else {
				$id = $_SESSION['publication_id'];
				$publication = $_POST['publication'];
				$publication_id = $_POST['publication_id'];
				$description = $_POST['description'];
	
				update_publication($id, $publication, $publication_id, $description);
				
				$smarty->assign('user_name',"$_SESSION[user_name]");
				$smarty->assign('page', "Publication");
				$smarty->display('publication/publication.tpl');
			}
		}
		elseif ($_REQUEST['job']=='edit'){
			$info=get_publication_info($_REQUEST['id']);
			$_SESSION['publication_id']=$_REQUEST['id'];
		
			$smarty->assign('publication',$info['publication']);
			$smarty->assign('publication_id',$info['publication_id']);
			$smarty->assign('description',$info['description']);
			
			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('edit_mode',"on");
			$smarty->assign('page', "Publication");
			$smarty->display('publication/publication.tpl');
		}
		elseif ($_REQUEST['job']=='delete'){
			cancel_publication($_REQUEST['id']);
		
			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('page', "Publication");
			$smarty->display('publication/publication.tpl');
		}
		elseif($_REQUEST['job']=='search'){
			$_SESSION['publication_search']=$_POST['search'];
		
			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('search',"$_SESSION[publication_search]");
			$smarty->assign('search_mode',"on");
			$smarty->assign('page', "Publication");
			$smarty->display('publication/publication.tpl');
		}
		else{
			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('page', "Publication");
			$smarty->display('publication/publication.tpl');
		}
	} 
	else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('user_name', "$_SESSION[user_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access PUBLICTION.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}

}
 else {
	$smarty->assign('error', "<p>Incorrect Login Details!</p>");
	$smarty->display('login.tpl');
}