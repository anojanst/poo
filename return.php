<?php
require_once 'conf/smarty-conf.php';
include 'functions/inventory_functions.php';
include 'functions/return_functions.php';
include 'functions/sales_functions.php';
include 'functions/ledger_functions.php';
include 'functions/user_functions.php';
include 'functions/navigation_functions.php';
include 'functions/multiple_stock_functions.php';


$module_no = 18;

if ($_SESSION['login'] == 1) {
    if (check_access($module_no, $_SESSION['user_id']) == 1) {

        if ($_REQUEST['job'] == 'barcode') {
            $selected_item = $_POST['barcode'];
            if (is_numeric($selected_item) && $selected_item < 100000) {
                $price = $selected_item;
            if (!isset ($_SESSION['return_no'])) {
                $_SESSION['return_no'] = $return_no = get_return_no();
            } else {
            }
            $return_no = $_SESSION['return_no'];
            $return_info = get_return_info_by_return_no($return_no);

            $product_name='COMMON ITEM';
            $stock=1;
            $selling_price=$price;

            add_return_item($product_id, $product_name, $stock, $selling_price, $discount, $_SESSION['return_no']);
            $total_to_ledger = ($selling_price / 100) * (100 - $discount);
            add_return_items_ledger($_SESSION['return_no'], $product_id, $total_to_ledger);

            $smarty->assign('customer_name', "$return_info[customer_name]");
            $smarty->assign('date', "$return_info[date]");
            $smarty->assign('remarks', "$return_info[remarks]");
            $smarty->assign('return_no', "$_SESSION[return_no]");
            if ($_SESSION['edit'] == 1) {
                $smarty->assign('edit_mode', "on");
                $smarty->assign('prepared_by', "$return_info[prepared_by]");
                $smarty->assign('updated_by', "$_SESSION[user_name]");
            } else {
                $smarty->assign('prepared_by', "$_SESSION[user_name]");
            }

            $total_without_discount= get_total_without_discount($_SESSION['return_no']);
            $return_total= get_total_return($_SESSION['return_no']);

            if($total_without_discount==$return_total){
                $smarty->assign('discount_display',"on");
            }else{
                $smarty->assign('discount_display',"off");
            }


            $smarty->assign('org_name', "$_SESSION[org_name]");
            $smarty->assign('total', get_total_return($_SESSION['return_no']));
            $smarty->assign('page', "Return");
            $smarty->display('return/return.tpl');

        
            } else {
                if (!isset($_SESSION['return_no'])) {
                    $_SESSION['return_no'] = $return_no = get_return_no();
                } else {
                }

                $return_no = $_SESSION['return_no'];
                $return_info = get_return_info_by_return_no($return_no);

                $info = get_item_info_by_barcode($selected_item);

                $product_name = $info['product_name'];
                $product_id = $info['product_id'];
                //$stock=get_total_stock($info['product_id']);
                $stock = get_branch_stock($product_id);
                $quantity = get_quantity_return($product_id, $_SESSION['return_no']);
                $multiple_info = get_multiple_stock_by_product_id($product_id);

                if ($product_id) {

                    if (check_added_items_return($product_id, $_SESSION['return_no']) == 1) {
                        $info_for_return_has_items = get_product_info_from_return_has_items($product_id, $return_no);
                        $selling_price = $info_for_return_has_items['selling_price'];
                        $discount = $info_for_return_has_items['discount'];
                        $quantity = $quantity + 1;
                        $item_total = ($quantity * $selling_price / 100) * (100 - $discount);

//$_SESSION['edit'] == 1 &&
                        if ($_SESSION['edit'] == 1 && $info_for_return_has_items['saved'] == 1) {
                            reupdate_inventory($product_id, $info_for_return_has_items['quantity'], $stock);
                        } else {
                        }
                        update_return_item_for_repeative_adding($product_id, $quantity, $item_total);
                        //update_sales_item_ledger($product_id ,$_SESSION['sales_no']);
                    } else {
                        $discount = $info['discount'];
                        $selling_price = $info['selling_price'];

                        add_return_item($product_id, $product_name, $stock, $selling_price, $discount, $_SESSION['return_no']);
                        $total_to_ledger = ($selling_price / 100) * (100 - $discount);
                        add_return_items_ledger($_SESSION['return_no'], $product_id, $total_to_ledger);


                    }

                    $smarty->assign('customer_name', "$sales_info[customer_name]");
                    $smarty->assign('date', "$sales_info[date]");
                    $smarty->assign('remarks', "$sales_info[remarks]");
                    $smarty->assign('return_no', "$_SESSION[return_no]");
                    if ($_SESSION['edit'] == 1) {
                        $smarty->assign('edit_mode', "on");
                        $smarty->assign('prepared_by', "$sales_info[prepared_by]");
                        $smarty->assign('updated_by', "$_SESSION[user_name]");
                    } else {
                        $smarty->assign('prepared_by', "$_SESSION[user_name]");
                    }

                    $total_without_discount = get_total_without_discount($_SESSION['return_no']);
                    $return_total = get_total_return($_SESSION['return_no']);

                    if ($total_without_discount == $return_total) {
                        $smarty->assign('discount_display', "on");
                    } else {
                        $smarty->assign('discount_display', "off");
                    }

                    $smarty->assign('org_name', "$_SESSION[org_name]");
                    $smarty->assign('total', get_total_return($_SESSION['return_no']));
                    $smarty->assign('page', "Return");
                    $smarty->display('return/return.tpl');

                }

                else {
                    $smarty->assign('stock_warning', "on");
                    $smarty->assign('stock_warning_message', "Product Not Existed in database.");

                    $smarty->assign('page', "Return");
                    $smarty->display('return/return.tpl');

                }
            }
        }



        elseif ($_REQUEST['job'] == 'select') {
            $selected_item = $_POST['selected_item'];
            if (!isset ($_SESSION['return_no'])) {
                $_SESSION['return_no'] = $return_no = get_return_no();
            } else {
            }
            $return_no = $_SESSION['return_no'];
            $return_info = get_return_info_by_return_no($return_no);

            $info = get_item_info_by_selected_name($selected_item);

            $product_name=$info['product_name'];
            $product_id = $info['product_id'];

            $stock = get_branch_stock($product_id);
            $quantity = get_quantity_return($product_id, $_SESSION['return_no']);
            if($product_id){
                if (check_added_items_return($product_id, $_SESSION['return_no']) == 1) {

                    $info_for_return_has_items = get_product_info_from_return_has_items($product_id, $return_no);
                    $selling_price = $info_for_return_has_items['selling_price'];
                    $discount = $info_for_return_has_items['discount'];
                    $quantity=$quantity+1;
                    $item_total = ($quantity * $selling_price / 100) * (100 - $discount);


                    if ($info_for_return_has_items['saved'] == 1) {
                        reupdate_inventory_for_return($product_id, $info_for_return_has_items['quantity'], $stock);
                    } else {
                    }


                    update_return_item_for_repeative_adding($product_id, $quantity, $item_total);
                    //update_return_item_ledger($product_id, $_SESSION['return_no']);

                }


                else {
                    $discount = $info['discount'];
                    $selling_price = $info['selling_price'];
                    add_return_item($product_id, $product_name, $stock, $selling_price, $discount, $_SESSION['return_no']);
                    $total_to_ledger = ($selling_price / 100) * (100 - $discount);
                    add_return_items_ledger($_SESSION['return_no'], $product_id, $total_to_ledger);

                }

                $smarty->assign('customer_name', "$return_info[customer_name]");
                $smarty->assign('date', "$return_info[date]");
                $smarty->assign('remarks', "$return_info[remarks]");
                $smarty->assign('return_no', "$_SESSION[return_no]");
                if ($_SESSION['edit'] == 1) {
                    $smarty->assign('edit_mode', "on");
                    $smarty->assign('prepared_by', "$return_info[prepared_by]");
                    $smarty->assign('updated_by', "$_SESSION[user_name]");
                } else {
                    $smarty->assign('prepared_by', "$_SESSION[user_name]");
                }

                $total_without_discount= get_total_without_discount($_SESSION['return_no']);
                $return_total= get_total_return($_SESSION['return_no']);

                if($total_without_discount==$return_total){
                    $smarty->assign('discount_display',"on");
                }else{
                    $smarty->assign('discount_display',"off");
                }


                $smarty->assign('org_name', "$_SESSION[org_name]");
                $smarty->assign('total', get_total_return($_SESSION['return_no']));
                $smarty->assign('page', "Return");
                $smarty->display('return/return.tpl');
            }
            else{
                $smarty->assign('stock_warning',"on");
                $smarty->assign('stock_warning_message',"Stock Mismatch Warning.");

                $smarty->assign('page', "Return");
                $smarty->display('return/return.tpl');
            }
        }

        elseif ($_REQUEST['job'] == 'product_no') {
            $product_no = $_POST['product_no'];
            if (!isset ($_SESSION['return_no'])) {
                $_SESSION['return_no'] = $return_no = get_return_no();
            } else {
            }
            $return_no = $_SESSION['return_no'];
            $return_info = get_return_info_by_return_no($return_no);

            $info=get_item_info_by_product_no($product_no) ;

            $product_name=$info['product_name'];
            $product_id = $info['product_id'];

            $stock = get_branch_stock($product_id);
            $quantity = get_quantity_return($product_id, $_SESSION['return_no']);

            if($product_id){
                if (check_added_items_return($product_id, $_SESSION['return_no']) == 1) {

                    $info_for_return_has_items = get_product_info_from_return_has_items($product_id, $return_no);
                    $selling_price = $info_for_return_has_items['selling_price'];
                    $discount = $info_for_return_has_items['discount'];
                    $quantity=$quantity+1;
                    $item_total = ($quantity * $selling_price / 100) * (100 - $discount);


                    if ($info_for_return_has_items['saved'] == 1) {
                        reupdate_inventory_for_return($product_id, $info_for_return_has_items['quantity'], $stock);
                    } else {
                    }


                    update_return_item_for_repeative_adding($product_id, $quantity, $item_total);
                    //update_return_item_ledger($product_id, $_SESSION['return_no']);

                }


                else {
                    $discount = $info['discount'];
                    $selling_price = $info['selling_price'];
                    add_return_item($product_id, $product_id, $stock, $selling_price, $discount, $_SESSION['return_no']);
                    $total_to_ledger = ($selling_price / 100) * (100 - $discount);
                    add_return_items_ledger($_SESSION['return_no'], $product_id, $total_to_ledger);

                }

                $smarty->assign('customer_name', "$return_info[customer_name]");
                $smarty->assign('date', "$return_info[date]");
                $smarty->assign('remarks', "$return_info[remarks]");
                $smarty->assign('return_no', "$_SESSION[return_no]");
                if ($_SESSION['edit'] == 1) {
                    $smarty->assign('edit_mode', "on");
                    $smarty->assign('prepared_by', "$return_info[prepared_by]");
                    $smarty->assign('updated_by', "$_SESSION[user_name]");
                } else {
                    $smarty->assign('prepared_by', "$_SESSION[user_name]");
                }

                $total_without_discount= get_total_without_discount($_SESSION['return_no']);
                $return_total= get_total_return($_SESSION['return_no']);

                if($total_without_discount==$return_total){
                    $smarty->assign('discount_display',"on");
                }else{
                    $smarty->assign('discount_display',"off");
                }


                $smarty->assign('org_name', "$_SESSION[org_name]");
                $smarty->assign('total', get_total_return($_SESSION['return_no']));
                $smarty->assign('page', "Return");
                $smarty->display('return/return.tpl');
            }
            else{
                $smarty->assign('stock_warning',"on");
                $smarty->assign('stock_warning_message',"Stock Mismatch Warning.");

                $smarty->assign('page', "Return");
                $smarty->display('return/return.tpl');
            }
        }

        elseif ($_REQUEST['job'] == 'price') {
            $price = $_POST['price'];
            if (!isset ($_SESSION['return_no'])) {
                $_SESSION['return_no'] = $return_no = get_return_no();
            } else {
            }
            $return_no = $_SESSION['return_no'];
            $return_info = get_return_info_by_return_no($return_no);

            $product_name='COMMON ITEM';
            $stock=1;
            $selling_price=$price;

            add_return_item($product_id, $product_name, $stock, $selling_price, $discount, $_SESSION['return_no']);
            $total_to_ledger = ($selling_price / 100) * (100 - $discount);
            add_return_items_ledger($_SESSION['return_no'], $product_id, $total_to_ledger);

            $smarty->assign('customer_name', "$return_info[customer_name]");
            $smarty->assign('date', "$return_info[date]");
            $smarty->assign('remarks', "$return_info[remarks]");
            $smarty->assign('return_no', "$_SESSION[return_no]");
            if ($_SESSION['edit'] == 1) {
                $smarty->assign('edit_mode', "on");
                $smarty->assign('prepared_by', "$return_info[prepared_by]");
                $smarty->assign('updated_by', "$_SESSION[user_name]");
            } else {
                $smarty->assign('prepared_by', "$_SESSION[user_name]");
            }

            $total_without_discount= get_total_without_discount($_SESSION['return_no']);
            $return_total= get_total_return($_SESSION['return_no']);

            if($total_without_discount==$return_total){
                $smarty->assign('discount_display',"on");
            }else{
                $smarty->assign('discount_display',"off");
            }


            $smarty->assign('org_name', "$_SESSION[org_name]");
            $smarty->assign('total', get_total_return($_SESSION['return_no']));
            $smarty->assign('page', "Return");
            $smarty->display('return/return.tpl');

        }

        elseif ($_REQUEST['job'] == 'update_item') {
            $id = $_REQUEST['id'];
            $product_id = $_REQUEST['product_id'];
            $quantity = $_POST['quantity'];
            $selling_price = $_POST['selling_price'];
            $discount = $_POST['discount'];
            $user_name = $_SESSION['user_name'];
            $item_total = ($quantity * $selling_price / 100) * (100 - $discount);
            //$stock = get_total_stock_return($_REQUEST['product_id']);
            $stock = get_branch_stock($product_id);
            $price=$selling_price*$quantity;
            $return_no = $_SESSION['return_no'];
            $return_info = get_return_info_by_return_no($return_no);
            $item_info = get_product_info_from_return_has_items($product_id, $return_no);


            if ($_SESSION['edit'] == 1 && $item_info['saved'] == 1) {
                reupdate_inventory_for_return($product_id, $item_info['quantity'], $stock);
            } else {
            }


            update_return_item($id, $product_id, $quantity, $item_total, $selling_price, $discount, $return_no, $stock);
            update_return_item_ledger($product_id, $return_no);

            $smarty->assign('customer_name', "$return_info[customer_name]");
            $smarty->assign('date', "$return_info[date]");
            $smarty->assign('remarks', "$return_info[remarks]");
            $smarty->assign('return_no', "$_SESSION[return_no]");
            if ($_SESSION['edit'] == 1) {
                $smarty->assign('edit_mode', "on");
                $smarty->assign('prepared_by', "$return_info[prepared_by]");
                $smarty->assign('updated_by', "$_SESSION[user_name]");

            } else {
                $smarty->assign('prepared_by', "$_SESSION[user_name]");
            }

            $total_without_discount= get_total_without_discount($_SESSION['return_no']);
            $return_total= get_total_return($_SESSION['return_no']);

            if($total_without_discount==$return_total){
                $smarty->assign('discount_display',"on");
            }else{
                $smarty->assign('discount_display',"off");
            }


            $smarty->assign('return_no', "$_SESSION[return_no]");
            $smarty->assign('prepared_by', "$_SESSION[user_name]");
            $smarty->assign('total', get_total_return($_SESSION['return_no']));
            $smarty->assign('org_name', "$_SESSION[org_name]");
            $smarty->assign('page', "return");
            $smarty->display('return/return.tpl');
        }

        elseif ($_REQUEST['job'] == 'search') {
            $_SESSION['return_no_search'] = $_POST['return_no_search'];
            $_SESSION['customer_search'] = $_POST['customer_search'];

            $smarty->assign('search_mode', "on");
            unset ($_SESSION['return_no']);
            $smarty->assign('return_no_search', "$_SESSION[return_no_search]");
            $smarty->assign('customer_search', "$_SESSION[customer_search]");
            $smarty->assign('org_name', "$_SESSION[org_name]");
            $smarty->assign('total', "$total");
            $smarty->assign('page', "Return");
            $smarty->display('return/return.tpl');
        }
        elseif ($_REQUEST['job'] == 'edit') {
            $_SESSION['edit'] = 1;

            $_SESSION['id'] = $id = $_REQUEST['id'];
            $info = get_return_info($id);
            $_SESSION['return_no'] = $info['return_no'];
            $supplier_name = $info['supplier_name'];
            $remarks = $info['remarks'];
            $prepared_by = $info['prepared_by'];
            $date = $info['date'];

            $total_without_discount= get_total_without_discount($_SESSION['return_no']);
            $return_total= get_total_return($_SESSION['return_no']);

            if($total_without_discount==$return_total){
                $smarty->assign('discount_display',"on");
            }else{
                $smarty->assign('discount_display',"off");
            }

            $smarty->assign('edit_mode', "on");
            $smarty->assign('updated_by', "$_SESSION[user_name]");
            $smarty->assign('total', get_total_return($_SESSION['return_no']));
            $smarty->assign('parent_catagorys', list_parent_catagory());
            $smarty->assign('return_no', "$_SESSION[return_no]");
            $smarty->assign('customer_name', "$info[customer_name]");
            $smarty->assign('date', "$info[date]");
            $smarty->assign('remarks', "$info[remarks]");
            $smarty->assign('supplier_search', "$_SESSION[supplier_search]");
            $smarty->assign('org_name', "$_SESSION[org_name]");
            $smarty->assign('return_no', "$_SESSION[return_no]");
            $smarty->assign('prepared_by', "$info[prepared_by]");
            $smarty->assign('page', "Return");
            $smarty->display('return/return.tpl');
        }
        elseif ($_REQUEST['job'] == 'delete_item') {

            $id = $_REQUEST['id'];
            $info = get_product_info_from_return_has_items_by_id($id);
            $item_info = get_product_info_from_return_has_items($info['product_id'], $_SESSION['return_no']);
            $stock = get_total_stock_return($info['product_id']);

            if ($_SESSION['edit'] == 1 && $item_info['saved'] == 1) {
                reupdate_inventory_for_return($info['product_id'], $item_info['quantity'], $stock);
            } else {
            }
            cancel_item_return($id);
            delete_return_items_ledger($id);

            $return_no = $_SESSION['return_no'];
            $return_info = get_return_info_by_return_no($return_no);

            $smarty->assign('customer_name', "$return_info[customer_name]");
            $smarty->assign('date', "$return_info[date]");
            $smarty->assign('remarks', "$return_info[remarks]");
            $smarty->assign('return_no', "$_SESSION[return_no]");

            if ($_SESSION['edit'] == 1) {
                $smarty->assign('edit_mode', "on");
                $smarty->assign('prepared_by', "$return_info[prepared_by]");
                $smarty->assign('updated_by', "$_SESSION[user_name]");

            } else {
                $smarty->assign('prepared_by', "$_SESSION[user_name]");
            }

            $smarty->assign('org_name', "$_SESSION[org_name]");
            $smarty->assign('return_no', "$_SESSION[return_no]");
            $smarty->assign('total', get_total_return($_SESSION['return_no']));

            $total_without_discount= get_total_without_discount($_SESSION['return_no']);
            $return_total= get_total_return($_SESSION['return_no']);

            if($total_without_discount==$return_total){
                $smarty->assign('discount_display',"on");
            }else{
                $smarty->assign('discount_display',"off");
            }


            $smarty->assign('prepared_by', "$_SESSION[user_name]");
            $smarty->assign('page', "Return");
            $smarty->display('return/return.tpl');
        }

        elseif ($_REQUEST['job'] == 'return') {

            if ($_REQUEST['ok'] == 'Finish the Return Bill & Print') {

                $date = date("Y-m-d");
                $remarks=$_POST['remarks'];
                $customer_name = $_POST['customer_name'];
                $prepared_by = $_POST['prepared_by'];
                $return_no = $_POST['return_no'];
                $total = get_total_return($_SESSION['return_no']);
                save_return($return_no, $date, $customer_name, $prepared_by, $remarks, $total);
                add_return_ledger($return_no);

            } else {

                $id = $_SESSION['id'];
                $date = $_POST['date'];
                $remarks = $_POST['remarks'];
                $customer_name = $_POST['customer_name'];
                $prepared_by = $_POST['prepared_by'];
                $updated_by = $_POST['updated_by'];
                $return_no = $_POST['return_no'];
                $total = get_total_return($_SESSION['return_no']);
                update_return($id, $return_no, $date, $customer_name, $prepared_by, $remarks, $total, $updated_by);
                update_return_ledger($return_no);
                unset ($_SESSION['edit']);
            }

            $branch=$_SESSION['branch'];
            update_inventory_after_return($_SESSION['return_no']);
            update_inventory_after_returns_in_branch($return_no, $branch);
            update_saved_return($_SESSION['return_no']);

            $smarty->assign('parent_catagorys', list_parent_catagory());
            $smarty->assign('return_count',no_of_return_items($_SESSION['return_no']));
            $smarty->assign('return_pieces',no_of_return_pieces($_SESSION['return_no']));
            $smarty->assign('org_name', "$_SESSION[org_name]");
            $smarty->assign('return_no', "$_SESSION[return_no]");
            $smarty->assign('total', get_total_return($_SESSION['return_no']));
            $smarty->assign('page', "Return");
            $smarty->display('return/print.tpl');
        }

        elseif ($_REQUEST['job']=='add_item'){
            if (!isset($_SESSION['return_no'])) {
                $_SESSION['return_no']=$return_no=get_return_no();
            }
            else{
            }
            $product_name = $_POST['product_name'];
            $quantity = $_POST['quantity'];
            $selling_price = $_POST['selling_price'];
            $branch = $_SESSION['branch'];
            $discount=$_POST['discount'];
            $location='common';
            $purchased_date=date('Y-m-d');
            $item_type='TEMP';
            $serial_no=get_serial_no($item_type);
            $product_id= get_product_id($item_type);
            $barcode=$product_id;
            $total=($quantity*$selling_price/100)*(100-$discount);
            save_product($product_id, $product_name, $author, $isbn, $publication, $barcode, $quantity, $selling_price, $discount, $buying_price, $buying_discount, $product_description, $measure_type, $purchased_date, $exp_date, $supplier, $page, $size, $weight, $cover, $location, $name_in_ta, $type, $item_type, $serial_no, $quantity);

            save_items($product_id,$product_name,$quantity,$location);

            add_quick_return_item($product_id, $product_name, $quantity, $selling_price, $discount,$total, $_SESSION['return_no']);
            $smarty->assign('return_no',"$_SESSION[return_no]");
            $smarty->assign('page',"sales");
            $smarty->display('return/return.tpl');

        }

        elseif ($_REQUEST['job'] == 'must_new') {
            unset ($_SESSION['edit']);
            unset ($_SESSION['return_no']);
            unset ($_SESSION['remarks']);
            unset ($_SESSION['prepared_by']);
            unset ($_SESSION['updated_by']);
            unset ($_SESSION['supplier_name']);
            unset ($_SESSION['updated_by']);

            $smarty->assign('org_name', "$_SESSION[org_name]");
            $smarty->assign('parent_catagorys', list_parent_catagory());
            $smarty->assign('page', "Return");
            $smarty->display('return/return.tpl');
        }

        elseif ($_REQUEST['job'] == 'delete') {
            $module_no = 104;
            if (check_access($module_no, $_SESSION['user_id']) == 1) {
                $id = $_REQUEST['id'];

                $info = get_return_info($id);
                $return_no_for_delete = $info['return_no'];

                calncel_items_for_return_no($return_no_for_delete);
                cancel_return($id);
                delete_return_ledger($return_no_for_delete);
                delete_all_return_items_ledger($return_no_for_delete);

                $smarty->assign('search_mode', "on");
                unset ($_SESSION['return_no']);
                $smarty->assign('return_no_search', "$_SESSION[return_no_search]");
                $smarty->assign('customer_search', "$_SESSION[customer_search]");
                $smarty->assign('org_name', "$_SESSION[org_name]");
                $smarty->assign('page', "Return");
                $smarty->display('return/return.tpl');
            } else {
                $user_name = $_SESSION['user_name'];
                $smarty->assign('org_name', "$_SESSION[org_name]");
                $smarty->assign('error_report', "on");
                $smarty->assign('error_message', "Dear $user_name, you don't have permission to DELETE return sales.");
                $smarty->assign('page', "Access Error");
                $smarty->display('user_home/access_error.tpl');
            }
        } else {
            unset ($_SESSION['edit']);
            unset ($_SESSION['return_no']);
            unset ($_SESSION['remarks']);
            unset ($_SESSION['prepared_by']);
            unset ($_SESSION['updated_by']);
            unset ($_SESSION['supplier_name']);
            unset ($_SESSION['updated_by']);
            if (check_non_saved_return_order($_SESSION['user_name']) == 1) {
                $_SESSION['return_no'] = non_save_return_info($_SESSION['user_name']);

                $info = get_return_info_by_return_no($_SESSION['return_no']);
                $customer_name = $info['customer_name'];
                $remarks = $info['remarks'];
                $prepared_by = $info['prepared_by'];
                $date = $info['date'];
                $_SESSION['edit'] = 1;
                if ($customer_name) {
                    $smarty->assign('new', "Skip Editing and <a href='return.php?job=must_new' style='color: orange; font-size: 20px;'> Create New Perchase Order.</a>");
                    $smarty->assign('edit_mode', "on");
                    $smarty->assign('updated_by', "$_SESSION[user_name]");
                    $smarty->assign('customer_name', "$info[customer_name]");
                    $smarty->assign('date', "$info[date]");
                    $smarty->assign('remarks', "$info[remarks]");
                    $smarty->assign('prepared_by', "$info[prepared_by]");
                } else {
                    $smarty->assign('prepared_by', "$_SESSION[user_name]");
                }
            } else {

            }
            $total = get_total_return($_SESSION['return_no']);

            $smarty->assign('org_name', "$_SESSION[org_name]");
            $smarty->assign('parent_catagorys', list_parent_catagory());
            $smarty->assign('return_no', "$_SESSION[return_no]");

            $smarty->assign('total', "$total");
            $smarty->assign('page', "Return");
            $smarty->display('return/return.tpl');
        }
    } else {
        $user_name = $_SESSION['user_name'];
        $smarty->assign('org_name', "$_SESSION[org_name]");
        $smarty->assign('error_report', "on");
        $smarty->assign('error_message', "Dear $user_name, you don't have permission to access RETURN SALES.");
        $smarty->assign('page', "Access Error");
        $smarty->display('user_home/access_error.tpl');
    }
} else {
    $smarty->assign('page', "Home");
    $smarty->display('index.tpl');
}