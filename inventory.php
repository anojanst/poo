<?php
require_once 'conf/smarty-conf.php';
include 'functions/inventory_functions.php';
include 'functions/user_functions.php';
include 'functions/multiple_stock_functions.php';

$module_no=2;

if ($_SESSION['login']==1){
	if (check_access($module_no, $_SESSION['user_id'])==1){		
		
		if($_REQUEST['job']=='add'){
			if($_REQUEST['ok']=='Save'){
				
				$product_name=addslashes($_POST['product_name']);
				$author=$_POST['author'];
				$isbn=$_POST['isbn'];
                $count= $_POST['count'];
				$publication=$_POST['publication'];
				$barcode=$_POST['barcode'];
				$selling_price=$_POST['selling_price'];
				$buying_discount="";
				$buying_price=$selling_price;
				$discount=$_POST['discount'];;
				$product_description="";
				$measure_type=$_POST['measure_type'];
				$purchased_date=date("Y-m-d");
				$exp_date=date("Y-m-d");
				$label=$_POST['label'];
				$supplier="";
				$page=$_POST['page'];
				$size=$_POST['size'];
				$weight=$_POST['weight'];
				$location=$_POST['location'];
				$name_in_ta=addslashes($_POST['name_in_ta']);
				$type=$_POST['type'];
				$item_type=$_POST['item_type'];
				$quantity=$_POST['quantity'];


                $product_id=get_product_id($item_type);
                $serial_no=get_serial_no($item_type);

                if($_POST['barcode']){
					$barcode=$_POST['barcode'];
					
				}
				else{
					$barcode=$product_id;
				}
				
				$filename = stripslashes ($_FILES['cover'] ['name']);
				if($filename){
					$file_name=$product_id.'.'.$filename;
					$cover="cover/".$file_name;
					$copied = copy($_FILES['cover']['tmp_name'],$cover);
				}
				else{
					$cover="";
				}


                save_product($product_id, $product_name, $author, $isbn, $publication, $barcode, $count, $selling_price, $discount, $buying_price, $buying_discount, $product_description, $measure_type, $purchased_date, $exp_date, $supplier, $page, $size, $weight, $cover, $location, $name_in_ta, $type, $item_type, $serial_no, $quantity);
                save_items($product_id,$product_name,$count);

                $nlabel = count($label);
				 
				for($i=0; $i < $nlabel; $i++)
				{
					add_item_has_label($product_id, $label[$i]);
				}
				
				
				$info=get_inventory_info_by_product_id($product_id);
				$smarty->assign('product_id',$info['product_id']);
				$smarty->assign('id',$info['id']);
				$smarty->assign('product_name',$info['product_name']);
				$smarty->assign('buying_price',$info['buying_price']);
				$smarty->assign('selling_price',$info['selling_price']);
				$smarty->assign('buying_discount',$info['buying_discount']);
				$smarty->assign('discount',$info['discount']);
				$smarty->assign('product_description',$info['product_description']);
				$smarty->assign('measure_type',$info['measure_type']);
				$smarty->assign('type',$info['type']);
				$smarty->assign('exp_date',$info['exp_date']);
				$smarty->assign('purchased_date',$info['purchased_date']);
				$smarty->assign('supplier',$info['supplier']);
				$smarty->assign('page_count',$info['page']);
				$smarty->assign('size',$info['size']);
				$smarty->assign('weight',$info['weight']);
				$smarty->assign('author',$info['author']);
				$smarty->assign('isbn',$info['isbn']);
				$smarty->assign('publication',$info['publication']);
				$smarty->assign('barcode',$info['barcode']);
				$smarty->assign('cover',$info['cover']);
				$smarty->assign('location',$info['location']);
				$smarty->assign('name_in_ta',$info['name_in_ta']);
				$smarty->assign('quantity',$info['quantity']);
				
				
				$smarty->assign('user_name',"$_SESSION[user_name]");
				$smarty->assign('page',"Inventory");
				$smarty->display('inventory/details.tpl');
			}
			else{

				$id=$_SESSION['id'];
				$product_name=addslashes($_POST['product_name']);
				$author=$_POST['author'];
				$isbn=$_POST['isbn'];
				$publication=$_POST['publication'];
				$barcode=$_POST['barcode'];
				$count=$_POST['quantity'];
				$selling_price=$_POST['selling_price'];
				$buying_discount="";
				$buying_price=$selling_price;
				$discount=$_POST['discount'];
				$product_description="";
				$measure_type=$_POST['measure_type'];
				$purchased_date=date("Y-m-d");
				$exp_date=date("Y-m-d");
				
				$supplier="";
				$page=$_POST['page'];
				$size=$_POST['size'];
				$weight=$_POST['weight'];
				$location=$_POST['location'];
				$name_in_ta=$_POST['name_in_ta'];
				$type=$_POST['type'];
				$item_type=$_POST['item_type'];
				$info=get_product_info($id);
				$product_id=$info['product_id'];
				$filename = stripslashes ($_FILES['cover'] ['name']);
				if($filename){
					$file_name=$info['product_id'].'.'.$filename;
					$cover="cover/".$file_name;
					$copied = copy($_FILES['cover']['tmp_name'],$cover);
				}
				else{
					
					$cover=$info['cover'];
				}
				
				if($_POST['barcode']){
					$barcode=$_POST['barcode'];
					
				}
				else{
					$barcode=$product_id;
				}
				
				update_product($id, $product_name, $author, $isbn, $publication, $barcode, $count, $selling_price, $discount, $buying_price, $buying_discount, $product_description, $measure_type, $purchased_date, $exp_date, $supplier, $page, $size, $weight, $cover, $location, $name_in_ta, $type, $item_type);
				$label=$_POST['label'];
				$nlabel = count($label);
				$product_id=$info['product_id'];
				for($i=0; $i < $nlabel; $i++)
				{
					if(check_label($product_id, $label[$i])==1){
						
					}
					else {
						add_item_has_label($product_id, $label[$i]);
					}
				}
				
				unset($_SESSION['id']);
				
				$info=get_product_info($id);
				$smarty->assign('product_id',$info['product_id']);
				$smarty->assign('id',$id);
				$smarty->assign('product_name',$info['product_name']);
				$smarty->assign('count',$info['quantity']);
				$smarty->assign('buying_price',$info['buying_price']);
				$smarty->assign('selling_price',$info['selling_price']);
				$smarty->assign('buying_discount',$info['buying_discount']);
				$smarty->assign('discount',$info['discount']);
				$smarty->assign('product_description',$info['product_description']);
				$smarty->assign('measure_type',$info['measure_type']);
				$smarty->assign('exp_date',$info['exp_date']);
				$smarty->assign('purchased_date',$info['purchased_date']);
				$smarty->assign('supplier',$info['supplier']);
				$smarty->assign('page_count',$info['page']);
				$smarty->assign('size',$info['size']);
				$smarty->assign('weight',$info['weight']);
				$smarty->assign('author',$info['author']);
				$smarty->assign('isbn',$info['isbn']);
				$smarty->assign('publication',$info['publication']);
				$smarty->assign('barcode',$info['barcode']);
				$smarty->assign('cover',$info['cover']);
				$smarty->assign('location',$info['location']);
				$smarty->assign('name_in_ta',$info['name_in_ta']);
				$smarty->assign('type',$info['type']);
				
				$smarty->assign('quantity',$info['quantity']);
				
				$smarty->assign('user_name',"$_SESSION[user_name]");
				$smarty->assign('page',"Inventory");
				$smarty->display('inventory/details.tpl');
			}
		}
		elseif($_REQUEST['job']=='search'){
			$_SESSION['search']=$_POST['search'];

			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('search',"$_SESSION[search]");
			$smarty->assign('search_mode',"on");
			$smarty->assign('page',"Inventory");
			$smarty->display('inventory/inventory.tpl');
		}
		
		elseif($_REQUEST['job']=='replace_stock'){
			$id=$_REQUEST['id'];
			$new_stock=$_POST['new_stock'];
			replace_stock($id,$new_stock);
			
			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('page',"Add New Stock");
			$smarty->display('inventory/add_stock.tpl');
		}
		elseif ($_REQUEST['job']=='edit'){
			$module_no = 111;
			if (check_access($module_no, $_SESSION['user_id'])==1){
				$info=get_product_info($_REQUEST['id']);
				$_SESSION['id']=$_REQUEST['id'];
	
				$smarty->assign('product_name',$info['product_name']);
				$smarty->assign('quantity',$info['quantity']);
				$smarty->assign('buying_price',$info['buying_price']);
				$smarty->assign('selling_price',$info['selling_price']);
				$smarty->assign('buying_discount',$info['buying_discount']);
				$smarty->assign('discount',$info['discount']);
				$smarty->assign('product_description',$info['product_description']);
				$smarty->assign('measure_type',$info['measure_type']);
				$smarty->assign('exp_date',$info['exp_date']);
				$smarty->assign('purchased_date',$info['purchased_date']);
				$smarty->assign('supplier',$info['supplier']);
				$smarty->assign('page_count',$info['page']);
				$smarty->assign('size',$info['size']);
				$smarty->assign('weight',$info['weight']);
				$smarty->assign('author',$info['author']);
				$smarty->assign('isbn',$info['isbn']);
				$smarty->assign('publication',$info['publication']);
				$smarty->assign('barcode',$info['barcode']);
				$smarty->assign('location',$info['location']);
				$smarty->assign('name_in_ta',$info['name_in_ta']);
				$smarty->assign('type',$info['type']);
				$smarty->assign('item_type',$info['item_type']);
				
				$smarty->assign('parent_catagorys',list_parent_catagory());
				$smarty->assign('user_name',"$_SESSION[user_name]");
				$smarty->assign('edit',"Product");
				$smarty->assign('edit_mode',"on");
				$smarty->assign('page',"Inventory");
				$smarty->display('inventory/add_new.tpl');
			}
		
			else{
				$user_name=$_SESSION['user_name'];
				$smarty->assign('user_name',"$_SESSION[user_name]");
				$smarty->assign('error_report',"on");
				$smarty->assign('error_message',"Dear $user_name, you don't have permission to EDIT an item.");
				$smarty->assign('page',"Access Error");
				$smarty->display('user_home/access_error.tpl');
			}
		}
		elseif ($_REQUEST['job']=='delete'){
			$module_no= 101;
			if (check_access($module_no, $_SESSION['user_id'])==1){
				
				delete_inventory($_REQUEST['id']);

				$smarty->assign('parent_catagorys',list_parent_catagory());
				$smarty->assign('user_name',"$_SESSION[user_name]");
				$smarty->assign('page',"Inventory");
				$smarty->display('inventory/inventory.tpl');
			}
			else{
				$user_name=$_SESSION['user_name'];
				$smarty->assign('user_name',"$_SESSION[user_name]");
				$smarty->assign('error_report',"on");
				$smarty->assign('error_message',"Dear $user_name, you don't have permission to DELETE an item.");
				$smarty->assign('page',"Access Error");
				$smarty->display('user_home/access_error.tpl');
			}
		}
		elseif($_REQUEST['job']=='add_new'){
				
			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('page',"Add New");
			$smarty->display('inventory/add_new.tpl');
		}
		elseif($_REQUEST['job']=='add_stock'){
				
			$smarty->assign('parent_catagorys',list_parent_catagory());
			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('page',"Add New");
			$smarty->display('inventory/add_stock.tpl');
		}
		
		else{
			$smarty->assign('parent_catagorys',list_parent_catagory());
			$smarty->assign('user_name',"$_SESSION[user_name]");
			$smarty->assign('page',"Inventory");
			$smarty->display('inventory/inventory.tpl');
		}
	}
	else{
		$user_name=$_SESSION['user_name'];
		$smarty->assign('user_name',"$_SESSION[user_name]");
		$smarty->assign('error_report',"on");
		$smarty->assign('error_message',"Dear $user_name, you don't have permission to access INVENTORY.");
		$smarty->assign('page',"Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
}
else{
	$smarty->assign('error',"<p>Incorrect Login Details!</p>");
	$smarty->display('login.tpl');
}