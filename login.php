<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/sales_functions.php';

if ($_REQUEST['job']=="login"){

	$login=$_POST['user_name'];
	$password=$_POST['password'];

	if (check_login($login, $password)==1){
		
		
		$_SESSION['user_name']=$login;
		$info=get_detail_info();
		$user_info=get_user_info($login);
		$_SESSION['login']=1;
		
		$_SESSION['user_id']=$user_info['id'];
		$_SESSION['full_name']=$user_info['full_name'];
		$_SESSION['email']=$user_info['email'];
		$_SESSION['filled']=$info['filled'];
        $_SESSION['department']=$user_info['department'];
		$_SESSION['branch']=$user_info['branch'];
		
        
        if($_SESSION['department']== 'sales'){
            $smarty->assign('Page',"Sales");
            $smarty->display("sales/sales.tpl");
        }
		elseif($_SESSION['filled']==1){
			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('branch',"$_SESSION[branch]");
			
			$smarty->assign('page',"User Home");
			$smarty->display("user_home/user_home.tpl");
		}
      
		else {
			$smarty->assign('page',"User Settings");
			$smarty->display('detail/detail.tpl');
		}
		
	}

	else {

		$smarty->assign('error_report',"on");
		$smarty->assign('error_message',"Username and password not match");
		$smarty->display('login.tpl');
	}

}

elseif ($_REQUEST['job']=="logout"){

	unset($_SESSION['login']);
	unset($_SESSION['user_name']);
	unset($_SESSION['user_id']);
	unset($_SESSION['branch']);
	header('location: index.php');

}

else{
		$smarty->display('home/index.tpl');
}