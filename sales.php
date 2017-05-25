<?php
require_once 'conf/smarty-conf.php';
include 'functions/inventory_functions.php';
include 'functions/sales_functions.php';
include 'functions/ledger_functions.php';
include 'functions/user_functions.php';
include 'functions/navigation_functions.php';
include 'functions/multiple_stock_functions.php';

$module_no = 3;

if ($_SESSION['login'] == 1) {
    if (check_access($module_no, $_SESSION['user_id']) == 1) {

        if ($_REQUEST['job']=='barcode'){
            $selected_item=$_POST['barcode'];
            if(is_numeric($selected_item)&&$selected_item<100000){
                $price=$selected_item;
                if (!isset($_SESSION['sales_no'])) {
                    $_SESSION['sales_no']=$sales_no=get_sales_no();
                }
                else{
                }

                $sales_no=$_SESSION['sales_no'];
                $sales_info=get_sales_info_by_sales_no($sales_no);
                $product_name='COMMON ITEM';
                $stock=1;
                $selling_price=$price;
                add_sales_item($product_id, $product_name, $stock, $selling_price, $discount, $_SESSION['sales_no']);
                $total_to_ledger=($selling_price/100)*(100-$discount);
                add_sales_items_ledger($_SESSION['sales_no'], $product_id, $total_to_ledger);

                $smarty->assign('customer_name',"$sales_info[customer_name]");
                $smarty->assign('date',"$sales_info[date]");
                $smarty->assign('remarks',"$sales_info[remarks]");
                $smarty->assign('sales_no',"$_SESSION[sales_no]");
                if($_SESSION['edit']==1){
                    $smarty->assign('edit_mode',"on");
                    $smarty->assign('prepared_by',"$sales_info[prepared_by]");
                    $smarty->assign('updated_by',"$_SESSION[user_name]");
                }
                else{
                    $smarty->assign('prepared_by',"$_SESSION[user_name]");
                }

                $total_without_discount= get_total_without_discount($_SESSION['sales_no']);
                $sales_total= get_total_sales($_SESSION['sales_no']);

                if($total_without_discount==$sales_total){
                    $smarty->assign('discount_display',"on");
                }else{
                    $smarty->assign('discount_display',"off");
                }


                $smarty->assign('org_name',"$_SESSION[org_name]");
                $smarty->assign('total',get_total_sales($_SESSION['sales_no']));
                $smarty->assign('page',"sales");
                $smarty->display('sales/sales.tpl');
            }
            else {
                if (!isset($_SESSION['sales_no'])) {
                    $_SESSION['sales_no'] = $sales_no = get_sales_no();
                } else {
                }

                $sales_no = $_SESSION['sales_no'];
                $sales_info = get_sales_info_by_sales_no($sales_no);

                $info = get_item_info_by_barcode($selected_item);

                $product_name = $info['product_name'];
                $product_id = $info['product_id'];
                $type=$info['type'];
                //$stock=get_total_stock($info['product_id']);
                $stock = get_branch_stock($product_id);
                $quantity = get_quantity($product_id, $_SESSION['sales_no']);
                $multiple_info = get_multiple_stock_by_product_id($product_id);

                if ($product_id) {

                    if (check_added_items($product_id, $_SESSION['sales_no']) == 1) {
                        $info_for_sales_has_items = get_product_info_from_sales_has_items($product_id, $sales_no);
                        $selling_price = $info_for_sales_has_items['selling_price'];
                        $discount = $info_for_sales_has_items['discount'];
                        $quantity = $quantity + 1;
                        $item_total = ($quantity * $selling_price / 100) * (100 - $discount);
                        if (1 > 2) {//$stock<$quantity
                            //add_pending_order($selected_item, $product_name, $stock);
                            $smarty->assign('error_report', "on");
                            $smarty->assign('error_message', "Not Enough Stock.");
                        } else {

                            if ($_SESSION['edit'] == 1 && $info_for_sales_has_items['saved'] == 1) {
                                reupdate_inventory($product_id, $info_for_sales_has_items['quantity'], $stock);
                            } else {
                            }
                            update_sales_item_for_repeative_adding($product_id, $quantity, $item_total);
                            //update_sales_item_ledger($product_id ,$_SESSION['sales_no']);
                        }
                    } else {
                        if($type=="INDIA TAMIL"){
                            $selling_price=$info['selling_price']*3.75;
                        }
                        elseif($type=="INDIA ENGLISH"){
                            $selling_price=$info['selling_price']*3.5;
                        }
                        else{
                            $selling_price=$info['selling_price'];
                        }
                        $discount = $info['discount'];


                        if ($stock < $quantity) {
                            //add_pending_order($product_id);
                            $smarty->assign('error_report', "on");
                            $smarty->assign('error_message', "Not Enough Stock.");
                        } else {
                        }

                        add_sales_item($product_id, $product_name, $stock, $selling_price, $discount, $_SESSION['sales_no']);
                        $total_to_ledger = ($selling_price / 100) * (100 - $discount);
                        echo $total_to_ledger;
                        add_sales_items_ledger($_SESSION['sales_no'], $product_id, $total_to_ledger);

                    }

                    $smarty->assign('customer_name', "$sales_info[customer_name]");
                    $smarty->assign('date', "$sales_info[date]");
                    $smarty->assign('remarks', "$sales_info[remarks]");
                    $smarty->assign('sales_no', "$_SESSION[sales_no]");
                    if ($_SESSION['edit'] == 1) {
                        $smarty->assign('edit_mode', "on");
                        $smarty->assign('prepared_by', "$sales_info[prepared_by]");
                        $smarty->assign('updated_by', "$_SESSION[user_name]");
                    } else {
                        $smarty->assign('prepared_by', "$_SESSION[user_name]");
                    }

                    $total_without_discount = get_total_without_discount($_SESSION['sales_no']);
                    $sales_total = get_total_sales($_SESSION['sales_no']);

                    if ($total_without_discount == $sales_total) {
                        $smarty->assign('discount_display', "on");
                    } else {
                        $smarty->assign('discount_display', "off");
                    }

                    $smarty->assign('org_name', "$_SESSION[org_name]");
                    $smarty->assign('total', get_total_sales($_SESSION['sales_no']));
                    $smarty->assign('page', "sales");
                    $smarty->display('sales/sales.tpl');

                }

                else{
                    $smarty->assign('stock_warning',"on");
                    $smarty->assign('stock_warning_message',"Product Not Existed in database.");

                    $smarty->assign('page',"sales");
                    $smarty->display('sales/sales.tpl');

                }
            }
        }

        elseif ($_REQUEST['job']=='select'){
            $selected_item=$_POST['selected_item'];
            if (!isset($_SESSION['sales_no'])) {
                $_SESSION['sales_no']=$sales_no=get_sales_no();
            }
            else{
            }

            $sales_no=$_SESSION['sales_no'];
            $sales_info=get_sales_info_by_sales_no($sales_no);

            $info=get_item_info_by_selected_name($selected_item);

            $product_name=$info['product_name'];
            $product_id=$info['product_id'];
            $type=$info['type'];
            //$stock=get_total_stock($info['product_id']);
            $stock = get_branch_stock($product_id);
            $quantity=get_quantity($product_id, $_SESSION['sales_no']);
            $multiple_info=get_multiple_stock_by_product_id($product_id);

            if($product_id){
                if(check_added_items($product_id, $_SESSION['sales_no'])==1){
                    $info_for_sales_has_items=get_product_info_from_sales_has_items($product_id, $sales_no);
                    $selling_price=$info_for_sales_has_items['selling_price'];
                    $discount=$info_for_sales_has_items['discount'];
                    $quantity=$quantity+1;
                    $item_total=($quantity*$selling_price/100)*(100-$discount);

                    if($stock<$quantity){
                        //add_pending_order($selected_item, $product_name, $stock);
                        $smarty->assign('error_report',"on");
                        $smarty->assign('error_message',"Not Enough Stock.");
                    }

                    else {

                        if ($_SESSION['edit'] == 1 && $info_for_sales_has_items['saved'] == 1) {
                            reupdate_inventory($product_id, $info_for_sales_has_items['quantity'], $stock);
                        } else {
                        }


                        update_sales_item_for_repeative_adding($product_id, $quantity, $item_total);
                        //update_sales_item_ledger($product_id ,$_SESSION['sales_no']);
                    }
                }
                else{
                    if($type=="INDIA TAMIL"){
                        $selling_price=$info['selling_price']*3.75;
                    }
                    elseif($type=="INDIA ENGLISH"){
                        $selling_price=$info['selling_price']*3.5;
                    }
                    else{
                        $selling_price=$info['selling_price'];
                    }
                    $discount=$info['discount'];

                    if($stock<$quantity){
                        //add_pending_order($product_id);
                        $smarty->assign('error_report',"on");
                        $smarty->assign('error_message',"Not Enough Stock.");
                    }

                    else{}

                    add_sales_item($product_id, $product_name, $stock, $selling_price, $discount, $_SESSION['sales_no']);
                    $total_to_ledger=($selling_price/100)*(100-$discount);
                    add_sales_items_ledger($_SESSION['sales_no'], $product_id, $total_to_ledger);


                }

                $smarty->assign('customer_name',"$sales_info[customer_name]");
                $smarty->assign('date',"$sales_info[date]");
                $smarty->assign('remarks',"$sales_info[remarks]");
                $smarty->assign('sales_no',"$_SESSION[sales_no]");
                if($_SESSION['edit']==1){
                    $smarty->assign('edit_mode',"on");
                    $smarty->assign('prepared_by',"$sales_info[prepared_by]");
                    $smarty->assign('updated_by',"$_SESSION[user_name]");
                }
                else{
                    $smarty->assign('prepared_by',"$_SESSION[user_name]");
                }


                $total_without_discount= get_total_without_discount($_SESSION['sales_no']);
                $sales_total= get_total_sales($_SESSION['sales_no']);

                if($total_without_discount==$sales_total){
                    $smarty->assign('discount_display',"on");
                }else{
                    $smarty->assign('discount_display',"off");
                }


                $smarty->assign('org_name',"$_SESSION[org_name]");
                $smarty->assign('total',get_total_sales($_SESSION['sales_no']));
                $smarty->assign('page',"sales");
                $smarty->display('sales/sales.tpl');

            }else{
                $smarty->assign('stock_warning',"on");
                $smarty->assign('stock_warning_message',"Stock Mismatch Warning.");

                $smarty->assign('page',"sales");
                $smarty->display('sales/sales.tpl');
            }
        }

        elseif ($_REQUEST['job']=='price'){
            $price=$_POST['price'];
            if (!isset($_SESSION['sales_no'])) {
                $_SESSION['sales_no']=$sales_no=get_sales_no();
            }
            else{
            }

            $sales_no=$_SESSION['sales_no'];
            $sales_info=get_sales_info_by_sales_no($sales_no);
            $product_name='COMMON ITEM';
            $stock=1;
            $selling_price=$price;
            add_sales_item($product_id, $product_name, $stock, $selling_price, $discount, $_SESSION['sales_no']);
            $total_to_ledger=($selling_price/100)*(100-$discount);
            add_sales_items_ledger($_SESSION['sales_no'], $product_id, $total_to_ledger);

            $smarty->assign('customer_name',"$sales_info[customer_name]");
            $smarty->assign('date',"$sales_info[date]");
            $smarty->assign('remarks',"$sales_info[remarks]");
            $smarty->assign('sales_no',"$_SESSION[sales_no]");
            if($_SESSION['edit']==1){
                $smarty->assign('edit_mode',"on");
                $smarty->assign('prepared_by',"$sales_info[prepared_by]");
                $smarty->assign('updated_by',"$_SESSION[user_name]");
            }
            else{
                $smarty->assign('prepared_by',"$_SESSION[user_name]");
            }

            $total_without_discount= get_total_without_discount($_SESSION['sales_no']);
            $sales_total= get_total_sales($_SESSION['sales_no']);

            if($total_without_discount==$sales_total){
                $smarty->assign('discount_display',"on");
            }else{
                $smarty->assign('discount_display',"off");
            }


            $smarty->assign('org_name',"$_SESSION[org_name]");
            $smarty->assign('total',get_total_sales($_SESSION['sales_no']));
            $smarty->assign('page',"sales");
            $smarty->display('sales/sales.tpl');
        }
        elseif ($_REQUEST['job']=='product_no'){
            $product_no=$_POST['product_no'];
            if (!isset($_SESSION['sales_no'])) {
                $_SESSION['sales_no']=$sales_no=get_sales_no();
            }
            else{
            }

            $sales_no=$_SESSION['sales_no'];
            $sales_info=get_sales_info_by_sales_no($sales_no);

            $info=get_item_info_by_product_no($product_no) ;

            $product_name=$info['product_name'];
            $product_id=$info['product_id'];
            $type=$info['type'];
            //$stock=get_total_stock($info['product_id']);
            $stock = get_branch_stock($product_id);
            $quantity=get_quantity($product_id, $_SESSION['sales_no']);
            $multiple_info=get_multiple_stock_by_product_id($product_id);

            if($product_id){
                if(check_added_items($product_id, $_SESSION['sales_no'])==1){
                    $info_for_sales_has_items=get_product_info_from_sales_has_items($product_id, $sales_no);
                    $selling_price=$info_for_sales_has_items['selling_price'];
                    $discount=$info_for_sales_has_items['discount'];
                    $quantity=$quantity+1;
                    $item_total=($quantity*$selling_price/100)*(100-$discount);

                    if($stock<$quantity){
                        //add_pending_order($selected_item, $product_name, $stock);
                        $smarty->assign('error_report',"on");
                        $smarty->assign('error_message',"Not Enough Stock.");
                    }

                    else {

                        if ($_SESSION['edit'] == 1 && $info_for_sales_has_items['saved'] == 1) {
                            reupdate_inventory($product_id, $info_for_sales_has_items['quantity'], $stock);
                        } else {
                        }


                        update_sales_item_for_repeative_adding($product_id, $quantity, $item_total);
                        //update_sales_item_ledger($product_id ,$_SESSION['sales_no']);
                    }
                }
                else{
                    if($type=="INDIA TAMIL"){
                        $selling_price=$info['selling_price']*3.75;
                    }
                    elseif($type=="INDIA ENGLISH"){
                        $selling_price=$info['selling_price']*3.5;
                    }
                    else{
                        $selling_price=$info['selling_price'];
                    }
                    $discount=$info['discount'];

                    if($stock<$quantity){
                        //add_pending_order($product_id);
                        $smarty->assign('error_report',"on");
                        $smarty->assign('error_message',"Not Enough Stock.");
                    }

                    else{}

                    add_sales_item($product_id, $product_name, $stock, $selling_price, $discount, $_SESSION['sales_no']);
                    $total_to_ledger=($selling_price/100)*(100-$discount);
                    add_sales_items_ledger($_SESSION['sales_no'], $product_id, $total_to_ledger);


                }

                $smarty->assign('customer_name',"$sales_info[customer_name]");
                $smarty->assign('date',"$sales_info[date]");
                $smarty->assign('remarks',"$sales_info[remarks]");
                $smarty->assign('sales_no',"$_SESSION[sales_no]");
                if($_SESSION['edit']==1){
                    $smarty->assign('edit_mode',"on");
                    $smarty->assign('prepared_by',"$sales_info[prepared_by]");
                    $smarty->assign('updated_by',"$_SESSION[user_name]");
                }
                else{
                    $smarty->assign('prepared_by',"$_SESSION[user_name]");
                }


                $total_without_discount= get_total_without_discount($_SESSION['sales_no']);
                $sales_total= get_total_sales($_SESSION['sales_no']);

                if($total_without_discount==$sales_total){
                    $smarty->assign('discount_display',"on");
                }else{
                    $smarty->assign('discount_display',"off");
                }


                $smarty->assign('org_name',"$_SESSION[org_name]");
                $smarty->assign('total',get_total_sales($_SESSION['sales_no']));
                $smarty->assign('page',"sales");
                $smarty->display('sales/sales.tpl');

            }else{
                $smarty->assign('stock_warning',"on");
                $smarty->assign('stock_warning_message',"Stock Mismatch Warning.");

                $smarty->assign('page',"sales");
                $smarty->display('sales/sales.tpl');
            }
        }

        elseif($_REQUEST['job']=='update_item'){
            $id=$_REQUEST['id'];
            $product_id=$_REQUEST['product_id'];
            $quantity=$_POST['quantity'];
            $selling_price=$_POST['selling_price'];
            $discount=$_POST['discount'];
            if($discount<100){
                $user_name=$_SESSION['user_name'];
                $item_total=($quantity*$selling_price/100)*(100-$discount);
                //$stock=get_total_stock($_REQUEST['product_id']);
                $stock = get_branch_stock($product_id);
                $price=$selling_price*$quantity;
                $sales_no=$_SESSION['sales_no'];
                $sales_info=get_sales_info_by_sales_no($sales_no);
                $item_info=get_product_info_from_sales_has_items($product_id, $sales_no);


                if($_SESSION['edit']==1 && $item_info['saved']==1){
                    reupdate_inventory($product_id, $item_info['quantity'], $stock);
                }
                else{
                }
                update_sales_item($id,$product_id, $quantity, $item_total, $selling_price, $discount, $sales_no, $stock);
                update_sales_item_ledger($product_id ,$sales_no);


                $smarty->assign('customer_name',"$sales_info[customer_name]");
                $smarty->assign('date',"$sales_info[date]");
                $smarty->assign('remarks',"$sales_info[remarks]");
                $smarty->assign('sales_no',"$_SESSION[sales_no]");
                if($_SESSION['edit']==1){
                    $smarty->assign('edit_mode',"on");
                    $smarty->assign('prepared_by',"$sales_info[prepared_by]");
                    $smarty->assign('updated_by',"$_SESSION[user_name]");

                }
                else{
                    $smarty->assign('prepared_by',"$_SESSION[user_name]");
                }


                $total_without_discount= get_total_without_discount($_SESSION['sales_no']);
                $sales_total= get_total_sales($_SESSION['sales_no']);

                if($total_without_discount==$sales_total){
                    $smarty->assign('discount_display',"on");
                }else{
                    $smarty->assign('discount_display',"off");
                }


                $smarty->assign('sales_no',"$_SESSION[sales_no]");
                $smarty->assign('prepared_by',"$_SESSION[user_name]");
                $smarty->assign('total',get_total_sales($_SESSION['sales_no']));
                $smarty->assign('org_name',"$_SESSION[org_name]");
                $smarty->assign('page',"sales");
                $smarty->display('sales/sales.tpl');
            }
            else{
                $user_name = $_SESSION['user_name'];
                $smarty->assign('org_name', "$_SESSION[org_name]");
                $smarty->assign('pay_error', "on");
                $smarty->assign('sales_no',"$_SESSION[sales_no]");
                $smarty->assign('total',get_total_sales($_SESSION['sales_no']));
                $smarty->assign('prepared_by',"$_SESSION[user_name]");
                $smarty->assign('pay_error_msg', "Dear $user_name, customer paying amount or Discount can't be morethan 100%");
                $smarty->assign('page', "Sales");
                $smarty->display('sales/sales.tpl');
            }
        }
        elseif ($_REQUEST['job']=='print_sales'){
            $sales_info=get_product_info_from_sales_has_items($product_id, $sales_no);

            $_SESSION['sales_no']=$sales_no=$_REQUEST['sales_no'];
            $date=$_REQUEST['date'];

            $smarty->assign('org_name',"$_SESSION[org_name]");
            $smarty->assign('date',"$date");
            $smarty->assign('sales_no',"$sales_no");

            $smarty->assign('page',"sales");
            $smarty->display('sales_reports/past_sales.tpl');
        }

        elseif ($_REQUEST['job']=='search'){
            $_SESSION['sales_no_search']=$_POST['sales_no_search'];
            $_SESSION['customer_search']=$_POST['customer_search'];

            $smarty->assign('search_mode',"on");
            unset($_SESSION['sales_no']);
            $smarty->assign('sales_no_search',"$_SESSION[sales_no_search]");
            $smarty->assign('customer_search',"$_SESSION[customer_search]");
            $smarty->assign('org_name',"$_SESSION[org_name]");
            $smarty->assign('total',"$total");
            $smarty->assign('page',"sales");
            $smarty->display('sales/sales.tpl');
        }
        elseif ($_REQUEST['job']=='edit'){
            $_SESSION['edit']=1;


            $_SESSION['id']=$id=$_REQUEST['id'];
            $info=get_sales_info($id);
            $_SESSION['sales_no']=$info['sales_no'];
            $supplier_name=$info['supplier_name'];
            $remarks=$info['remarks'];
            $prepared_by=$info['prepared_by'];
            $date=$info['date'];

            $total_without_discount= get_total_without_discount($_SESSION['sales_no']);
            $sales_total= get_total_sales($_SESSION['sales_no']);

            if($total_without_discount==$sales_total){
                $smarty->assign('discount_display',"on");
            }else{
                $smarty->assign('discount_display',"off");
            }

            $smarty->assign('edit_mode',"on");
            $smarty->assign('updated_by',"$_SESSION[user_name]");
            $smarty->assign('total',get_total_sales($_SESSION['sales_no']));
            $smarty->assign('parent_catagorys',list_parent_catagory());
            $smarty->assign('sales_no',"$_SESSION[sales_no]");
            $smarty->assign('customer_name',"$info[customer_name]");
            $smarty->assign('date',"$info[date]");
            $smarty->assign('remarks',"$info[remarks]");
            $smarty->assign('supplier_search',"$_SESSION[supplier_search]");
            $smarty->assign('org_name',"$_SESSION[org_name]");
            $smarty->assign('sales_no',"$_SESSION[sales_no]");
            $smarty->assign('prepared_by',"$info[prepared_by]");
            $smarty->assign('page',"sales");
            $smarty->display('sales/sales.tpl');
        }

        elseif ($_REQUEST['job']=='delete_item'){

            $id=$_REQUEST['id'];
            $info=get_product_info_from_sales_has_items_by_id($id);
            $item_info=get_product_info_from_sales_has_items($info['product_id'], $_SESSION['sales_no']);
            $stock=get_total_stock($info['product_id']);

            if($_SESSION['edit']==1 && $item_info['saved']==1){
                reupdate_inventory($info['product_id'], $item_info['quantity'], $stock);
            }
            else{
            }

            cancel_item($id);
            delete_sales_items_ledger($id);


            $sales_no=$_SESSION['sales_no'];
            $sales_info=get_sales_info_by_sales_no($sales_no);


            $smarty->assign('customer_name',"$sales_info[customer_name]");
            $smarty->assign('date',"$sales_info[date]");
            $smarty->assign('remarks',"$sales_info[remarks]");
            $smarty->assign('sales_no',"$_SESSION[sales_no]");

            if($_SESSION['edit']==1){
                $smarty->assign('edit_mode',"on");
                $smarty->assign('prepared_by',"$sales_info[prepared_by]");
                $smarty->assign('updated_by',"$_SESSION[user_name]");
            }
            else{
                $smarty->assign('prepared_by',"$_SESSION[user_name]");
            }


            $smarty->assign('org_name',"$_SESSION[org_name]");
            $smarty->assign('sales_no',"$_SESSION[sales_no]");
            $smarty->assign('total',get_total_sales($_SESSION['sales_no']));

            $total_without_discount= get_total_without_discount($_SESSION['sales_no']);
            $sales_total= get_total_sales($_SESSION['sales_no']);

            if($total_without_discount==$sales_total){
                $smarty->assign('discount_display',"on");
            }else{
                $smarty->assign('discount_display',"off");
            }

            $smarty->assign('prepared_by',"$_SESSION[user_name]");
            $smarty->assign('page',"sales");
            $smarty->display('sales/sales.tpl');
        }


        elseif($_REQUEST['job']=='sales'){

            if($_REQUEST['ok']=='Finish the Bill & Print'){
                $date = date("Y-m-d");
                $remarks=$_POST['remarks'];

                $customer_name=$_POST['customer_name'];
                $gift_card_no=$_POST['gift_card_no'];
                $prepared_by=$_POST['prepared_by'];
                $sales_no=$_POST['sales_no'];
                $total=get_total_sales($_SESSION['sales_no']);
                $discount=($total/100)*$_POST['discount'];
                $payment_type=$_POST['payment_type'];

                if($_POST['customer_amount']){
                    $customer_amount=$_POST['customer_amount'];
                }
                elseif($payment_type=='GIFT'){
                    $customer_amount=$_POST['customer_amount'];
                }
                else{
                    $customer_amount=$total;
                }

                $gift_card_info=get_gift_card_amount_from_gift_voucher($gift_card_no);
                $gift_card_amount=$gift_card_info['voucher_amount'];



                if($payment_type=='GIFT'){
                    $customer_amount=$customer_amount+$gift_card_amount;


                }else{
                    $customer_amount;
                }

                if( $payment_type!='GIFT'){
                    if(($total-$discount)>$customer_amount || $discount>$total ){
                        $user_name = $_SESSION['user_name'];
                        $smarty->assign('org_name', "$_SESSION[org_name]");
                        $smarty->assign('pay_error', "on");
                        $smarty->assign('sales_no',"$_SESSION[sales_no]");
                        $smarty->assign('total',get_total_sales($_SESSION['sales_no']));
                        $smarty->assign('prepared_by',"$_SESSION[user_name]");

                        $smarty->assign('pay_error_msg', "Dear $user_name, customer paying amount or Discount can't be less than TOTAL");


                        $smarty->assign('page', "Sales");
                        $smarty->display('sales/sales.tpl');
                    }
                    else{
                        $total_after_discount= $total-$discount;
                        $balance=$customer_amount-$total_after_discount;
                        save_sales($sales_no, $date, $customer_name, $prepared_by, $remarks,$discount,$customer_amount, $total_after_discount, $total,$balance, $payment_type, $gift_card_no);
                        add_sales_ledger($sales_no);
                        $info=get_sales_info_by_sales_no($sales_no);
                        if($info['payment_type']=='CASH' || $info['payment_type']=='CARD') {
                            add_sales_payment_ledger($sales_no);
                        }
                        else{}
                        $branch=$_SESSION['branch'];
                        update_inventory_after_sales($_SESSION['sales_no']);
                        update_inventory_after_sales_in_branch($sales_no, $branch);
                        update_saved_sales($_SESSION['sales_no']);
                        $_SESSION['print_no']=$_SESSION['sales_no'];
                        unset($_SESSION['sales_no']);
                        $_SESSION['discount_percentage']=$_POST['discount'];


                        $smarty->assign('parent_catagorys',list_parent_catagory());
                        $smarty->assign('count',no_of_items($_SESSION['print_no']));
                        $smarty->assign('pieces',no_of_pieces($_SESSION['print_no']));
                        $smarty->assign('org_name',"$_SESSION[org_name]");
                        $smarty->assign('date',"$date");
                        $smarty->assign('sales',"$_SESSION[print_no]");
                        $smarty->assign('total',get_total_sales($_SESSION['sales_no']));
                        $smarty->assign('page',"sales");
                        $smarty->display('sales/print.tpl');

                    }
                }

                if( $payment_type=='GIFT'){
                    if(($total-$discount)>$customer_amount || $discount>$total ){
                        $user_name = $_SESSION['user_name'];
                        $smarty->assign('org_name', "$_SESSION[org_name]");
                        $smarty->assign('pay_error', "on");
                        $smarty->assign('sales_no',"$_SESSION[sales_no]");
                        $smarty->assign('total',get_total_sales($_SESSION['sales_no']));
                        $smarty->assign('prepared_by',"$_SESSION[user_name]");

                        if(check_gift_card($gift_card_no)==1){
                            $smarty->assign('pay_error_msg', "Dear $user_name, customer paying amount is $_POST[customer_amount] AND gift card amount is $gift_card_amount but total amount is $total ");
                        }
                        else{
                            $smarty->assign('pay_error_msg', "Dear $user_name, This Gift Card is Invalide ");

                        }

                        $smarty->assign('page', "Sales");
                        $smarty->display('sales/sales.tpl');
                    }


                    else{
                        $total_after_discount= $total-$discount;
                        $balance=$customer_amount-$total_after_discount;
                        save_sales($sales_no, $date, $customer_name, $prepared_by, $remarks,$discount,$customer_amount, $total_after_discount, $total,$balance, $payment_type, $gift_card_no);
                        add_sales_ledger($sales_no);
                        $branch=$_SESSION['branch'];
                        update_inventory_after_sales($_SESSION['sales_no']);
                        update_inventory_after_sales_in_branch($sales_no, $branch);
                        update_saved_sales($_SESSION['sales_no']);
                        update_gift_voucher_status($gift_card_no);
                        $_SESSION['print_no']=$_SESSION['sales_no'];
                        unset($_SESSION['sales_no']);
                        $_SESSION['discount_percentage']=$_POST['discount'];


                        $smarty->assign('parent_catagorys',list_parent_catagory());
                        $smarty->assign('count',no_of_items($_SESSION['print_no']));
                        $smarty->assign('pieces',no_of_pieces($_SESSION['print_no']));
                        $smarty->assign('org_name',"$_SESSION[org_name]");
                        $smarty->assign('date',"$date");
                        $smarty->assign('sales',"$_SESSION[print_no]");
                        $smarty->assign('total',get_total_sales($_SESSION['sales_no']));
                        $smarty->assign('page',"sales");
                        $smarty->display('sales/print.tpl');

                    }
                }
            }
            else {

                $id=$_SESSION['id'];
                $date=date('Y-m-d');
                $remarks=$_POST['remarks'];
                $discount=$_POST['discount'];
                $customer_name=$_POST['customer_name'];
                $prepared_by=$_POST['prepared_by'];
                $updated_by=$_POST['updated_by'];
                $sales_no=$_POST['sales_no'];
                $total=get_total_sales($_SESSION['sales_no']);
                update_sales($id, $sales_no, $date, $customer_name, $prepared_by, $remarks,$discount, $total, $updated_by);
                update_sales_ledger($sales_no);
                unset($_SESSION['edit']);

                $branch=$_SESSION['branch'];
                update_inventory_after_sales($_SESSION['sales_no']);
                update_inventory_after_sales_in_branch($sales_no, $branch);
                update_saved_sales($_SESSION['sales_no']);
                $_SESSION['print_no']=$_SESSION['sales_no'];
                unset($_SESSION['sales_no']);

                $smarty->assign('parent_catagorys',list_parent_catagory());
                $smarty->assign('org_name',"$_SESSION[org_name]");

                $_SESSION['discount_percentage']=$_POST['discount'];

                $smarty->assign('date',"$date");
                $smarty->assign('sales',"$_SESSION[print_no]");
                $smarty->assign('total',get_total_sales($_SESSION['sales_no']));
                $smarty->assign('page',"sales");
                $smarty->display('sales/print.tpl');
            }
        }

        elseif ($_REQUEST['job']=='must_new'){
            unset($_SESSION['edit']);
            unset($_SESSION['sales_no']);
            unset($_SESSION['remarks']);
            unset($_SESSION['prepared_by']);
            unset($_SESSION['updated_by']);
            unset($_SESSION['supplier_name']);
            unset($_SESSION['updated_by']);


            $smarty->assign('org_name',"$_SESSION[org_name]");
            $smarty->assign('parent_catagorys',list_parent_catagory());
            $smarty->assign('page',"sales");
            $smarty->display('sales/sales.tpl');
        }
        elseif ($_REQUEST['job']=='add_item'){
            if (!isset($_SESSION['sales_no'])) {
                $_SESSION['sales_no']=$sales_no=get_sales_no();
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

            add_quick_sales_item($product_id, $product_name, $quantity, $selling_price, $discount,$total, $_SESSION['sales_no']);
            $smarty->assign('sales_no',"$_SESSION[sales_no]");
            $smarty->assign('page',"sales");
            $smarty->display('sales/sales.tpl');

        }
        elseif ($_REQUEST['job']=='delete'){
            $module_no = 103;
            if (check_access($module_no, $_SESSION['user_id']) == 1) {
                $id=$_REQUEST['id'];

                $info=get_sales_info($id);
                $sales_no_for_delete=$info['sales_no'];

                calncel_items_for_sales_no($sales_no_for_delete);
                cancel_sales($id);
                delete_sales_ledger($sales_no_for_delete);
                delete_all_sales_items_ledger($sales_no_for_delete);

                $smarty->assign('search_mode',"on");
                unset($_SESSION['sales_no']);
                $smarty->assign('sales_no_search',"$_SESSION[sales_no_search]");
                $smarty->assign('customer_search',"$_SESSION[customer_search]");
                $smarty->assign('org_name',"$_SESSION[org_name]");
                $smarty->assign('page',"sales");
                $smarty->display('sales/sales.tpl');
            } else {
                $user_name = $_SESSION['user_name'];
                $smarty->assign('org_name', "$_SESSION[org_name]");
                $smarty->assign('error_report', "on");
                $smarty->assign('error_message', "Dear $user_name, you don't have permission to DELETE a sales.");
                $smarty->assign('page', "Access Error");
                $smarty->display('user_home/access_error.tpl');
            }
        }

        else {
            unset($_SESSION['edit']);
            unset($_SESSION['sales_no']);
            unset($_SESSION['remarks']);
            unset($_SESSION['prepared_by']);
            unset($_SESSION['updated_by']);
            unset($_SESSION['supplier_name']);
            unset($_SESSION['updated_by']);
            if(check_non_saved_sales_order($_SESSION['user_name'])==1){
                $_SESSION['sales_no']=non_save_sales_info($_SESSION['user_name']);

                $info=get_sales_info_by_sales_no($_SESSION['sales_no']);
                $customer_name=$info['customer_name'];
                $remarks=$info['remarks'];
                $prepared_by=$info['prepared_by'];
                $date=$info['date'];
                $_SESSION['edit']=1;
                if ($customer_name){
                    $smarty->assign('new',"Skip Editing and <a href='sales.php?job=must_new' style='color: orange; font-size: 20px;'> Create New Perchase Order.</a>");
                    $smarty->assign('edit_mode',"on");
                    $smarty->assign('updated_by',"$_SESSION[user_name]");
                    $smarty->assign('customer_name',"$info[customer_name]");
                    $smarty->assign('date',"$info[date]");
                    $smarty->assign('remarks',"$info[remarks]");
                    $smarty->assign('prepared_by',"$info[prepared_by]");
                }
                else {
                    $smarty->assign('prepared_by',"$_SESSION[user_name]");
                }
            }
            else{

            }
            $total=get_total_sales($_SESSION['sales_no']);

            $smarty->assign('org_name',"$_SESSION[org_name]");
            $smarty->assign('parent_catagorys',list_parent_catagory());
            $smarty->assign('sales_no',"$_SESSION[sales_no]");

            $smarty->assign('total',"$total");
            $smarty->assign('page',"sales");
            $smarty->display('sales/sales.tpl');
        }
    } else {
        $user_name = $_SESSION['user_name'];
        $smarty->assign('org_name', "$_SESSION[org_name]");
        $smarty->assign('error_report', "on");
        $smarty->assign('error_message', "Dear $user_name, you don't have permission to access SALES.");
        $smarty->assign('page', "Access Error");
        $smarty->display('user_home/access_error.tpl');
    }
}
else{
    $smarty->assign('page',"Home");
    $smarty->display('index.tpl');
}