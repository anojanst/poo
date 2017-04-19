<?php
require_once 'conf/smarty-conf.php';
include 'functions/register_functions.php';
include 'libs/class.phpmailer.php';

if ($_REQUEST['job']=="register_form"){

	$smarty->assign('page',"Register");
	$smarty->display('register/register.tpl');
}

elseif ($_REQUEST['job']=="register"){

	$_SESSION['user_name']=$user_name=$_POST['user_name'];
	$_SESSION['org_name']=$org_name=$_POST['org_name'];
	$_SESSION['email']=$email=$_POST['email'];
	$_SESSION['password']=$password=$_POST['password'];
	$_SESSION['password_rep']=$password_rep=$_POST['password_rep'];
	$prefix_db="acc_";
	$db=$prefix_db.$_SESSION['user_name'];

	if($password == $password_rep){
		$password=md5($password);
		$code=$password_rep;
		register($user_name, $password, $org_name, $email, $code, $db);
		send_mail_for_activation($org_name, $user_name, $email);
		$smarty->assign('page',"Home");
		$smarty->display('index.tpl');
	}
	else{
		$smarty->assign('notice','Password doesn\'t match with repeated password');
		
		$smarty->assign('page',"Register");
		$smarty->display('register/register.tpl');
	}


}

else{
	$smarty->assign('page',"Register");
	$smarty->display('register/register.tpl');
}


