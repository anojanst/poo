<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/multiple_stock_functions.php';
include 'functions/inventory_functions.php';
include 'functions/navigation_functions.php';

$module_no = 200;

if ($_SESSION['login'] == 1) {
    if (check_access($module_no, $_SESSION['user_id']) == 1) {
        if ($_REQUEST ['job'] == "save") {

            $product_name = $_POST ['product_name'];
            $branch = $_POST ['branch'];
            $stock = $_POST ['stock'];
            $reorder = $_POST ['reorder'];
            $location = $_POST ['location'];

            save_multiple_stock($product_name, $branch, $stock, $reorder, $location);
        }
        elseif
        ($_REQUEST ['job'] == "edit"){
            $_SESSION ['id'] = $id = $_REQUEST ['id'];
            $info = get_multiple_stock_by_id($id);

            $smarty->assign('product_name', $info ['product_name']);
            $smarty->assign('branch', $info ['branch']);
            $smarty->assign('stock', $info ['stock']);
            $smarty->assign('reorder', $info ['reorder']);
            $smarty->assign('location', $info ['location']);
            $smarty->assign('edit', 'on');


        }
        elseif
        ($_REQUEST ['job'] == "product_details"){
            $_SESSION ['product_name'] = $product_name = $_POST ['product_name'];
            $info = get_multiple_stock_by_name($product_name);

            $smarty->assign('product_name', $info ['product_name']);
            $smarty->assign('branch', $info ['branch']);
            $smarty->assign('stock', $info ['stock']);
            $smarty->assign('reorder', $info ['reorder']);
            $smarty->assign('location', $info ['location']);
        }
        elseif
        ($_REQUEST ['job'] == "delete"){
            cancel_multiple_stock($_REQUEST ['id']);
        }
        $smarty->assign('page', "Multiple Stock");
        $smarty->display('inventory/multiple_stock.tpl');

    } else {
        $user_name = $_SESSION['user_name'];
        $smarty->assign('org_name', "$_SESSION[org_name]");
        $smarty->assign('error_report', "on");
        $smarty->assign('error_message', "Dear $user_name, you don't have permission to access MULTIPLE STOCK.");
        $smarty->assign('page', "Access Error");
        $smarty->display('user_home/access_error.tpl');
    }
}
else {
    $smarty->assign('page', "Home");
    $smarty->display('index.tpl');
}