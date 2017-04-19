<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/author_functions.php';

$module_no = 19;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		if ($_REQUEST['job'] == 'save') {
			if($_REQUEST['ok']=='Save'){
				
				$author = $_POST['author'];
				$author_id = $_POST['author_id'];
				$description = $_POST['description'];
	
				save_author($author, $author_id, $description);
				
				$smarty->assign('user_name',"$_SESSION[user_name]");
				$smarty->assign('page', "Author");
				$smarty->display('author/author.tpl');
			}
			
			else {
				$id = $_SESSION['author_id'];
				$author = $_POST['author'];
				$author_id = $_POST['author_id'];
				$description = $_POST['description'];
	
				update_author($id, $author, $author_id, $description);
				
				$smarty->assign('user_name',"$_SESSION[user_name]");
				$smarty->assign('page', "Author");
				$smarty->display('author/author.tpl');
			}
		}
		elseif ($_REQUEST['job']=='edit'){
			$info=get_author_info($_REQUEST['id']);
			$_SESSION['author_id']=$_REQUEST['id'];
		
			$smarty->assign('author',$info['author']);
			$smarty->assign('author_id',$info['author_id']);
			$smarty->assign('description',$info['description']);
			
			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('edit_mode',"on");
			$smarty->assign('page', "Author");
			$smarty->display('author/author.tpl');
		}
		elseif ($_REQUEST['job']=='delete'){
			cancel_author($_REQUEST['id']);
		
			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('page', "Author");
			$smarty->display('author/author.tpl');
		}
		elseif($_REQUEST['job']=='search'){
			$_SESSION['author_search']=$_POST['search'];
		
			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('search',"$_SESSION[author_search]");
			$smarty->assign('search_mode',"on");
			$smarty->assign('page', "Author");
			$smarty->display('author/author.tpl');
		}
		else{
			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('page', "Author");
			$smarty->display('author/author.tpl');
		}
	} 
	else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('user_name', "$_SESSION[user_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access AUTHOR.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}

}
 else {
	$smarty->assign('error', "<p>Incorrect Login Details!</p>");
	$smarty->display('login.tpl');
}