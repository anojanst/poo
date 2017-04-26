<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/author_functions.php';
include 'functions/notifications_functions.php';
include 'functions/navigation_functions.php';

$module_no = 19;

if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		if ($_REQUEST['job']=='notifications'){
		
			$smarty->assign('page',"Notifications");
			$smarty->display('notifications/notifications.tpl');
		
		}
		
		elseif ($_REQUEST ['job'] == "view_info") {
		
			$product_id=$_SESSION['product_id']=$_REQUEST['product_id'];
			$branch=$_SESSION['branch']=$_REQUEST['branch'];
				
			$smarty->assign ( 'product_id', $product_id );

			$smarty->assign ( 'page', "Notification Info" );
			$smarty->display ( 'notifications/notification_view.tpl' );
				
		}
		
		elseif ($_REQUEST ['job'] == "update_unseen") {
		
			$product_id=$_SESSION['product_id']=$_REQUEST['product_id'];
			$branch=$_SESSION['branch']=$_REQUEST['branch'];
		
			update_unseen_as_seen($product_id, $branch);
		
			$smarty->assign ( 'page', "Notification Info" );
			$smarty->display ( 'notifications/notifications.tpl' );
		
		}
        elseif ($_REQUEST ['job'] == "view_not") {

            $product_id=$_SESSION['product_id']=$_REQUEST['product_id'];
            $branch=$_SESSION['branch']=$_REQUEST['branch'];

            update_unseen_as_seen($product_id, $branch);

            $smarty->assign ( 'product_id', $product_id );

            $smarty->assign ( 'page', "Notification Info" );
            $smarty->display ( 'notifications/notification_view.tpl' );

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