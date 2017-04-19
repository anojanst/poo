<?php
session_start();
ini_set("session.gc_maxlifetime", "18000"); 

require('libs/Smarty.class.php');
$smarty = new Smarty;

ini_set ('displayerrors', true);
error_reporting (E_ALL + E_NOTICE);

$real_name=$_SESSION['real_name'];
$smarty->assign('real_name', $real_name);

$_SESSION['cash_error_correction']=-1805672.13;
$_SESSION['cash_error_correction_date']='01-07-2012';