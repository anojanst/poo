<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';

if ($_SESSION['login']==1){
	
	$smarty->assign('user_name',"$_SESSION[user_name]");
	$smarty->assign('page',"User Home");
	$smarty->display('user_home/user_home.tpl');
}
else{
	$smarty->assign('error',"Incorrect Login Details!");
	$smarty->display('login.tpl');
}