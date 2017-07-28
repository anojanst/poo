<?php
function get_product_id($item_type){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result=mysqli_query($conn, "SELECT MAX(serial_no) FROM inventory WHERE item_type='$item_type'");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        if($item_type=="BOOK"){
            $item_type="B";
        }
		elseif($item_type=="TEMP"){
			$item_type="T";
		}
        else{
            $item_type="A";
        }
        $no=$row['MAX(serial_no)']+1;
        $no = str_pad($no, 5, "0", STR_PAD_LEFT);
        return "$item_type-$no";
    }
}




function get_serial_no($item_type){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MAX(serial_no) FROM inventory WHERE item_type='$item_type'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(serial_no)']+1;
	}

	include 'conf/closedb.php';
}



function list_inventory_basic_report() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<tbody>';
	$i = 1;
	$total=0;
	$result = mysqli_query($conn, "SELECT * FROM inventory WHERE cancel_status='0' ORDER BY id DESC LIMIT 500");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
			echo '
					<td>' . $row[product_id] . '</td>
							
					<td>' . $row[product_name] . '</td>							
							
					<td>' . $row[quantity] . '</td>';
		$product_id = $row[product_id];

		$result1 = mysqli_query($conn, "SELECT SUM(quantity) as sold FROM sales_has_items WHERE product_id LIKE '$product_id' AND cancel_status='0' ORDER BY id DESC LIMIT 500");
		while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
		echo '		<td>' . $row1[sold] . '</td>';
		}
		echo '
					<td>' . $row[selling_price] . '</td>					
					<td>' . $row[buying_price] . '</td>
					<td>' . number_format(($row[buying_price]*$row[quantity]), 2) . '</td>
					<td>' . $row[discount] . '&nbsp;%</td>
					<td>' . $row[purchased_date] . '</td>
				</tr>';

		$i++;
		$total=$total+($row[buying_price]*$row[quantity]);
	}
	
	echo '<tr><th>Total</th><th>'.number_format($total, 2).'</th></tr></tbody>';

	include 'conf/closedb.php';
}

function list_inventory_custom_report() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<div class="box-body">
				<table id="example1"  style="width: 30%;" class="table-responsive table-bordered table-striped dt-responsive">
	  
	<thead valign="top">
	<th>No</th>';
	if ($_SESSION['product_id']){
	echo '<th>Product ID</th>';
	$x=$x+1;
	}
	if ($_SESSION['product_name']){
	echo '<th>Product Name</th>';
	$x=$x+1;
	}
	if ($_SESSION['product_catagory']){
	echo '<th>Product Catagory</th>';
	$x=$x+1;
	}
	if ($_SESSION['stock']){
	echo '<th>Stock</th>';
	$x=$x+1;
	}
	if ($_SESSION['sold']){
	echo '<th>Sold</th>';
	$x=$x+1;
	}
	if ($_SESSION['selling_price']){
	echo '<th>Selling Price</th>';
	$x=$x+1;
	}
	if ($_SESSION['buying_price']){
	echo '<th>Buying Price</th>';
	$x=$x+1;
	}
	if ($_SESSION['stock_value']){
	echo '<th>Stock Value</th>';
	$x=$x+1;
	}
	if ($_SESSION['discount']){
	echo '<th>Discount</th>';
	$x=$x+1;
	}
	if ($_SESSION['purchase_date']){
	echo '<th>Purchased Date</th>';
	$x=$x+1;
	}
	echo'</thead>
	<tbody valign="top">';

	$i = 1;
	$total=0;
	$result = mysqli_query($conn, "SELECT * FROM inventory WHERE cancel_status='0' ORDER BY id DESC LIMIT 500");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		if ($row[quantity] == 0) {
			echo '<tr><td style="background-color:#920606; color:white;" align="center">' . $i . '</td>';
		} else {
			echo '<tr><td align="center">' . $i . '</td>';
		}
		
		
	if ($_SESSION['product_id']){
	echo '<td>' . $row[product_id] . '</td>';
	}
	if ($_SESSION['product_name']){
	echo '<td>' . $row[product_name] . '</td>';
	}
	if ($_SESSION['product_catagory']){
	echo '<td>' . $row[catagory] . '</td>';
	}
	if ($_SESSION['stock']){
	echo '<td align="right">' . $row[quantity] . '</td>';
	}
	$product_id = $row[product_id];
	if ($_SESSION['sold']){
		$result1 = mysqli_query($conn, "SELECT SUM(quantity) as sold FROM sales_has_items WHERE product_id LIKE '$product_id' AND cancel_status='0' ORDER BY id DESC LIMIT 500");
		while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
			echo '<td align="right">' . $row1[sold] . '</td>';
		}
	}
	if ($_SESSION['selling_price']){
	echo '<td align="right">' . $row[selling_price] . '</td>';
	}
	if ($_SESSION['buying_price']){
	echo '<td align="right">' . $row[buying_price] . '</td>';
	}
	if ($_SESSION['stock_value']){
	echo '<td align="right">' . number_format(($row[buying_price]*$row[quantity]), 2) . '</td>';
	}
	if ($_SESSION['discount']){
	echo '<td align="center">' . $row[discount] . '&nbsp;%</td>';
	}
	if ($_SESSION['purchase_date']){
	echo '<td align="center">' . $row[purchased_date] . '</td>';
	}
	
	echo '</tr>';

		$i++;
		$total=$total+($row[buying_price]*$row[quantity]);
	}
	if ($_SESSION['stock_value']){
		$x=$x-1;
	echo '<tr>
    <th colspan='.$x.'>Total</th>
	<th align="right">'.number_format($total, 2).'</th>
	</tr>';
	}
	echo'</tbody></table></div>';

	include 'conf/closedb.php';
}

function list_inventory_search($search) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<div class="table-responsive">
              <table class="table">
	<thead valign="top">
	<th>Edit</th>
	<th>Product ID</th>
	<th>Product Name</th>
	<th>Stock</th>
	<th>Selling Price</th>
	<th>Buying Price</th>
	<th>Purchased Date</th>
	<th>Delete</th>
	<th>Barcode</th>
	</thead>
	<tbody valign="top">';

	$result = mysqli_query($conn, "SELECT * FROM inventory WHERE product_name LIKE '%$search%' AND cancel_status='0' ORDER BY id DESC LIMIT 500");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo '
				<tr>
					<td><a href="inventory.php?job=edit&id=' . $row[id] . '"  ><img src="images/edit.png" alt="Edit" width="24" height="24"/></a></td>
		
					<td>' . $row[product_id] . '</td>
							
					<td>' . $row[product_name] . '</td>
							
					<td align="right">' . $row[quantity] . '</td>
					
					<td align="right">' . $row[selling_price] . '</td>
					
					<td align="right">' . $row[buying_price] . '</td>
				
					<td align="center">' . $row[purchased_date] . '</td>
				
					<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'inventory.php?job=delete&id=' . $row[id] . '\',\'No\',\'inventory.php?job=search\')"><img src="images/close.png" alt="Delete" height="24" width="24"/></a></td>
					
					<td><a href="html/BCGcode39.php?barcode=' . $row[barcode] . '&product_id=' . $row[product_id] . '&price=' . $row[selling_price] . '&name=' . $row[product_name] . '&type=' . $row[type] . '" target="blank" class="report_select" style="width: 70px; height: 30px; padding: 0px;">Print</a></td>
				</tr>';
	}
	echo '</tbody></table></div>';

	include 'conf/closedb.php';
}

function list_inventory_basic_report_search($search) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<div class="table-responsive">
              <table class="table">
	<thead valign="top">
	<th>No</th>
	<th>Product ID</th>
	<th>Product Name</th>
	<th>Product Catagory</th>
	<th>Stock</th>
	<th>Sold</th>
	<th>Selling Price</th>
	<th>Buying Price</th>
	<th>Stock Value</th>
	<th>Discount</th>
	<th>Purchased Date</th>
	
	</thead>
	<tbody valign="top">';

	$i = 1;
	$total=0;
	$result = mysqli_query($conn, "SELECT * FROM inventory WHERE product_name LIKE '%$search%' AND cancel_status='0' ORDER BY id DESC LIMIT 500");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		if ($row[quantity] == 0) {
			echo '
						<tr><td style="background-color:#920606; color:white;" align="center">' . $i . '</td>';
		} else {
			echo '
						<tr><td align="center">' . $i . '</td>';
		}
		echo '
					<td>' . $row[product_id] . '</td>
							
					<td>' . $row[product_name] . '</td>
							
					<td>' . $row[catagory] . '</td>
							
					<td align="right">' . $row[quantity] . '</td>
					
					';
		$product_id = $row[product_id];

		$result1 = mysqli_query($conn, "SELECT SUM(quantity) as sold FROM sales_has_items WHERE product_id LIKE '$product_id' AND cancel_status='0' ORDER BY id DESC LIMIT 500");
		while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
			echo '<td align="right">' . $row1[sold] . '</td>';
		}
		echo '
					<td align="right">' . $row[selling_price] . '</td>
					
					<td align="right">' . $row[buying_price] . '</td>
					<td align="right">' . number_format(($row[buying_price]*$row[quantity]), 2) . '</td>
					<td align="center">' . $row[discount] . '&nbsp;%</td>
					<td align="center">' . $row[purchased_date] . '</td></tr>';

		$i++;
		$total=$total+($row[buying_price]*$row[quantity]);
	}
	
	echo '<tr><th colspan="8">Total</th><th>'.number_format($total, 2).'</th></tr></tbody></table></div>';

	include 'conf/closedb.php';
}

function save_product($product_id, $product_name, $author, $isbn, $publication, $barcode, $count, $selling_price, $discount, $buying_price, $buying_discount, $product_description, $measure_type, $purchased_date, $exp_date, $supplier, $page, $size, $weight, $cover, $location, $name_in_ta, $type, $item_type, $serial_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	//$purchased_date = date("Y-m-d", strtotime($purchased_date));

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO inventory (id, product_id, product_name, author, isbn, publication, barcode, quantity, selling_price, discount, buying_price, buying_discount, product_description, measure_type, purchased_date, exp_date, supplier, page, size, weight, cover, created_by, location, name_in_ta, type, item_type, serial_no)
	VALUES ('', '$product_id', '$product_name', '$author', '$isbn', '$publication', '$barcode', '$count', '$selling_price', '$discount', '$buying_price', '$buying_discount', '$product_description', '$measure_type', '$purchased_date', '$exp_date', '$supplier', '$page', '$size', '$weight', '$cover', '$_SESSION[user_name]', '$location', '$name_in_ta', '$type', '$item_type', '$serial_no')";
	mysqli_query($conn, $query) or die(mysqli_error($conn));
	

	include 'conf/closedb.php';
}

function add_item_has_label($product_id, $label){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO item_has_label (id, product_id, label)
	VALUES ('', '$product_id', '$label')";
	mysqli_query($conn, $query) or die(mysqli_error($conn));

	include 'conf/closedb.php';
}

function check_label($product_id, $label) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT count(id) FROM item_has_label WHERE product_id='$product_id' AND label='$label'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		if ($row['count(id)'] >=1) {
			return 1;
		}
		else{
			return 0;
		}
	}
	include 'conf/closedb.php';
}

function update_product($id, $product_name, $author, $isbn, $publication, $barcode, $count, $selling_price, $discount, $buying_price, $buying_discount, $product_description, $measure_type, $purchased_date, $exp_date, $supplier, $page, $size, $weight, $cover, $location, $name_in_ta, $type, $item_type){
	include 'conf/config.php';
	include 'conf/opendb.php';

	//$purchased_date = date("Y-m-d", strtotime($purchased_date));
	//$exp_date = date("Y-m-d", strtotime($exp_date));

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE inventory SET
	product_name='$product_name',
	author='$author',
	isbn='$isbn',
	publication='$publication',
	barcode='$barcode',
	quantity='$count',
	selling_price='$selling_price',
	discount='$discount',
	buying_price='$buying_price',
	buying_discount='$buying_discount',
	product_description='$product_description',
	measure_type='$measure_type',
	purchased_date='$purchased_date',
	exp_date='$exp_date',
	supplier='$supplier',
	size='$size',
	page='$page',
	weight='$weight',
	cover='$cover',
	location='$location',
	name_in_ta='$name_in_ta',
	type='$type',
	item_type='$item_type',
	updated_by='$_SESSION[user_name]'
	WHERE id='$id'";

	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function update_product_by_product_id($product_id, $product_name, $author, $isbn, $publication, $count, $selling_price, $discount, $buying_price, $buying_discount, $product_description, $measure_type, $purchased_date, $exp_date, $label, $supplier, $page, $size, $weight, $location, $name_in_ta, $type) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$purchased_date = date("Y-m-d", strtotime($purchased_date));
	$exp_date = date("Y-m-d", strtotime($exp_date));
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE inventory SET
	product_name='$product_name',
	author='$author',
	isbn='$isbn',
	publication='$publication',
	quantity='$count',
	selling_price='$selling_price',
	discount='$discount',
	buying_price='$buying_price',
	buying_discount='$buying_discount',
	product_description='$product_description',
	measure_type='$measure_type',
	purchased_date='$purchased_date',
	exp_date='$exp_date',
	label='$label',
	supplier='$supplier',
	size='$size',
	page='$page',
	weight='$weight',
	location='$location',
	name_in_ta='$name_in_ta',
	type='$type',
	updated_by='$_SESSION[user_name]'
	WHERE product_id='$product_id'";

	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function cancel_product($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE inventory SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]' 
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_product_info($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT * FROM inventory WHERE id='$id'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		return $row;
	}
	include 'conf/closedb.php';
}

function get_label_for_product_id($product_id){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT * FROM item_has_label WHERE product_id='$product_id'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$label=$row['label'].', '.$label;
	}
	return $label;
	include 'conf/closedb.php';
}

function save_catagory($catagory, $parent_catagory) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO catagories (id, catagory, parent_catagory)
	VALUES ('', '$catagory', '$parent_catagory')";
	mysqli_query($conn, $query) or die(mysqli_error($conn));

	include 'conf/closedb.php';
}

function list_catagories() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<div class="table-responsive">
              <table class="table">
	<thead valign="top">
	<th>Edit</th>
	<th>Catagory</th>
	<th>Delete</th>
	</thead>
	<tbody valign="top">';

	$result = mysqli_query($conn, "SELECT * FROM catagories WHERE cancel_status='0' ORDER BY id DESC LIMIT 500");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo '
				<tr>
					<td><a href="catagories.php?job=edit&id=' . $row[id] . '"  ><img src="images/edit.png" alt="Edit" width="24" height="24"/></a></td>
						
					<td>' . $row[catagory] . '</td>
							
					<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'catagories.php?job=delete&id=' . $row[id] . '\',\'No\',\'catagories.php\')"><img src="images/close.png" alt="Delete" height="24" width="24"/></a></td>
				</tr>';
	}
	echo '</tbody></table></div>';

	include 'conf/closedb.php';
}

//function list_parent_catagory() {
//    include 'conf/config.php';
//    include 'conf/opendb.php';

//    $result = mysqli_query($conn, "SELECT * FROM catagories WHERE cancel_status='0' ORDER BY id DESC LIMIT 500");
//    $i = 0;
//    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
//        $parent_catagory[$i] = $row['catagory'];
//        $i++;
//    }
//    return $parent_catagory;

//    include 'conf/closedb.php';
//}

function update_catagory($id, $catagory, $parent_catagory) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE catagories SET
	catagory='$catagory',
	parent_catagory='$parent_catagory'
	WHERE id='$id'";

	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_catagory_info($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT * FROM catagories WHERE id='$id'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		return $row;
	}
	include 'conf/closedb.php';
}

function cancel_catagory($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE catagories SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function check_parent_catagory($catagory) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT count(id) FROM catagories WHERE parent_catagory='$catagory' AND cancel_status='0'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		if ($row['count(id)'] >= 1) {
			return 1;
		} else {
			return 0;
		}
	}

	include 'conf/closedb.php';
}

function check_product($catagory) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT count(id) FROM inventory WHERE catagory='$catagory' AND cancel_status='0'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		if ($row['count(id)'] >= 1) {
			return 1;
		} else {
			return 0;
		}
	}

	include 'conf/closedb.php';
}

function get_item_info_by_name($product_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT * FROM inventory WHERE product_id='$product_id'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		return $row;
	}
	include 'conf/closedb.php';
}

function get_item_info_by_barcode($barcode) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT * FROM inventory WHERE barcode='$barcode'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		return $row;
	}
	include 'conf/closedb.php';
}


function get_item_info_by_selected_name($selected_item) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT * FROM inventory WHERE product_name='$selected_item'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		return $row;
	}
	include 'conf/closedb.php';
}

function check_added_items_inventory($product_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT count(id) FROM inventory WHERE product_id='$product_id' AND cancel_status='0'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		if ($row['count(id)'] >= 1) {
			return 1;
		} else {
			return 0;
		}
	}

	include 'conf/closedb.php';
}

function get_inventory_info_by_product_id($product_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT * FROM inventory WHERE product_id='$product_id'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		return $row;
	}
	include 'conf/closedb.php';
}

function reupdate_inventory($product_id, $quantity, $stock) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$new_stock = $stock + $quantity;

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE inventory SET
	quantity='$new_stock'
	WHERE product_id='$product_id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function reupdate_inventory_for_return($product_id, $quantity, $stock) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$new_stock = $stock - $quantity;

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE inventory SET
	quantity='$new_stock'
	WHERE product_id='$product_id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function update_inventory_after_sales($sales_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT * FROM sales_has_items WHERE sales_no='$sales_no' AND saved='0' AND cancel_status='0'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$product_id = $row['product_id'];
		$quantity = $row['quantity'];

		$info = get_inventory_info_by_product_id($product_id);
		$old_quantity = $info['quantity'];
		if($old_quantity==0) {
		    $new_quantity=0;
        }
        else{
            $new_quantity = $old_quantity - $quantity;
		}
		$query = "UPDATE inventory SET
				quantity='$new_quantity'
				WHERE product_id='$product_id'";
		mysqli_query($conn, $query);
	}
}

function update_inventory_after_sales_in_branch($sales_no, $branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT * FROM sales_has_items WHERE sales_no='$sales_no' AND saved='0' AND cancel_status='0'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$product_id = $row['product_id'];
		$quantity = $row['quantity'];
		
		$multiple_info=get_multiple_stock_by_product_id($product_id);
		$info = get_inventory_info_by_product_id_in_branch($product_id, $branch);
		$info2= get_inventory_info_by_product_id_in_inventory($product_id);
        if($row['product_name']!='COMMON ITEM'){
			$old_quantity = $info['stock'];
			$new_quantity = $old_quantity - $quantity;
			if($old_quantity==0||$new_quantity<=0) {
				$new_quantity=0;
			}
			else{
				
			}
			
			if(check_multiple_stock_has_inventory($product_id, $branch)==1){
			$query = "UPDATE inventory_has_multiple_stock SET
					stock='$new_quantity'
					WHERE product_id='$product_id' AND branch='$branch'";
					mysqli_query($conn, $query);
			}
			else{
				$location='common';
				$quantity=0;
				save_items($product_id,$info2['product_name'],$quantity,$location);
			}
		}
		else{
			
		}
	}
		$ref_type='Sales';
		
		if($info['reorder']>= $new_quantity){
			reorder_level_check($product_id,$branch,$new_quantity,$info2['product_name'],$info['reorder'], $sales_no, $ref_type);
		}
		else{
		}
	
	//mysqli_query($conn, $query);
	include 'conf/closedb.php';
}



function get_inventory_info_by_product_id_in_branch($product_id, $branch){
        include 'conf/config.php';
        include 'conf/opendb.php';

        $result = mysqli_query ($conn, "SELECT * FROM inventory_has_multiple_stock WHERE product_id='$product_id' AND branch='$branch'" );

        while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) )

        {
            return $row;
        }

}

function get_item_info_by_product_no($product_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query($conn, "SELECT * FROM inventory WHERE item_type='ACC' AND product_id LIKE '%$product_no'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		return $row;
	}
	include 'conf/closedb.php';
}

function get_inventory_info_by_product_id_in_inventory($product_id){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query ($conn, "SELECT * FROM inventory WHERE product_id='$product_id'" );

	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) )

	{
		return $row;
	}
	include 'conf/closedb.php';
}

function reorder_level_check($product_id,$branch,$stock,$product_name,$reorder, $sales_no, $ref_type) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$query = "INSERT INTO notification (id, product_id, branch,stock,product_name,reorder, ref_no, ref_type)
	VALUES ('', '$product_id', '$branch','$stock','$product_name','$reorder', '$sales_no', '$ref_type')";
	mysqli_query($conn, $query) or die(mysqli_error($conn));

	include 'conf/closedb.php';
}


function update_inventory_after_return($return_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT * FROM return_has_items WHERE return_no='$return_no' AND saved='0' AND cancel_status='0'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$product_id = $row['product_id'];
		$quantity = $row['quantity'];
		
		
		$info = get_inventory_info_by_product_id($product_id);
		$old_quantity = $info['quantity'];
		$new_quantity = $old_quantity + $quantity;

		
		$query = "UPDATE inventory_has_multiple_stock SET
				stock='$new_quantity'
				WHERE product_id='$product_id' AND branch='$branch'";
		
		
		mysqli_select_db($conn_for_changing_db, $dbname);
		$query = "UPDATE inventory SET
				quantity='$new_quantity'
				WHERE product_id='$product_id'";
		mysqli_query($conn, $query);
	}
}

function update_inventory_after_returns_in_branch($return_no, $branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT * FROM return_has_items WHERE return_no='$return_no' AND saved='0' AND cancel_status='0'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		
		$product_id = $row['product_id'];
		$quantity = $row['quantity'];
		
		$multiple_info=get_multiple_stock_by_product_id($product_id);
		$info = get_inventory_info_by_product_id_in_branch($product_id, $branch);
		$info2= get_inventory_info_by_product_id_in_inventory($product_id);
         if($row['product_name']!='COMMON ITEM'){
				$old_quantity = $info['stock'];
				$item_type=$info2['item_type'];
				echo $item_type;
				if($item_type!= 'TEMP'){
					$new_quantity = $old_quantity + $quantity;
				}
				else{
					$new_quantity = $old_quantity;
				}
				if(check_multiple_stock_has_inventory($product_id, $branch)==1){
						
				$query = "UPDATE inventory_has_multiple_stock SET
						stock='$new_quantity'
						WHERE product_id='$product_id' AND branch='$branch'";
						mysqli_query($conn, $query);
				}
				else{
					$location='common';
					save_items($product_id,$info2['product_name'],$quantity,$location);
				}
			}
			
			else{
			}
	}
		$ref_type='Sales';
		
		if($info['reorder']>= $new_quantity){
			reorder_level_check($product_id,$branch,$new_quantity,$info2['product_name'],$info['reorder'], $sales_no, $ref_type);
		}
		else{
		}
		
		include 'conf/closedb.php';
	}

	

function coustom_inventory_report($product_name, $supplier, $qty_less_than, $qty_more_than, $bp_less_than, $bp_more_than, $sp_less_than, $sp_more_than, $purchased_after, $purchased_before) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	if ($qty_less_than) {
		$qty_check = "AND quantity < '$qty_less_than'";
	}
	if ($qty_more_than) {
		$qty_check = "AND quantity > '$qty_more_than'";
	}
	if ($qty_less_than && $qty_more_than) {
		$qty_check = "";
	}

	if ($bp_less_than) {
		$bp_check = "AND buying_price < '$bp_less_than'";
	}
	if ($bp_more_than) {
		$bp_check = "AND buying_price > '$bp_more_than'";
	}
	if ($bp_less_than && $bp_more_than) {
		$bp_check = "";
	}

	if ($sp_less_than) {
		$sp_check = "AND selling_price < '$sp_less_than'";
	}
	if ($sp_more_than) {
		$sp_check = "AND selling_price > '$sp_more_than'";
	}
	if ($sp_less_than && $sp_more_than) {
		$sp_check = "";
	}

	if ($purchased_after) {
		$purchased_after = date("Y-m-d", strtotime($purchased_after));
		$purchased_check = "AND purchased_date >='$purchased_after'";
	}
	if ($purchased_before) {
		$purchased_before = date("Y-m-d", strtotime($purchased_before));
		$purchased_check = "AND purchased_date <='$purchased_before'";
	}
	if ($purchased_after && $purchased_before) {
		$purchased_check = "";
	}

	echo '<div class="row">      							
			<div class="box-body">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<th>No</th>
						<th>Product ID</th>
						<th>Product Name</th>
						<th>Product Catagory</th>
						<th>Stock</th>
						<th>Sold</th>
						<th>Selling Price</th>
						<th>Buying Price</th>
						<th>Discount</th>
						<th>Purchased Date</th>
						<th>Last Sales</th>
					</thead>
				<tbody>';

	$i = 1;
	$result = mysqli_query($conn, "SELECT * FROM inventory WHERE product_name LIKE '%$product_name%' AND cancel_status='0' AND supplier='$supplier' $bp_check $sp_check $qty_check $purchased_check ORDER BY id DESC LIMIT 500");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

		echo '<tr>
				<td align="center">' . $i . '</td>
					<td>' . $row[product_id] . '</td>
							
					<td>' . $row[product_name] . '</td>
							
					<td>' . $row[catagory] . '</td>
							
					<td align="right">' . $row[quantity] . '</td>
					
					';
		$product_id = $row[product_id];

		$result1 = mysqli_query($conn, "SELECT SUM(quantity) as sold FROM sales_has_items WHERE product_id LIKE '$product_id' AND cancel_status='0' ORDER BY id DESC LIMIT 500");
		while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
			echo '<td align="right">' . $row1[sold] . '</td>';
		}
		echo '
					<td align="right">' . $row[selling_price] . '</td>
					
					<td align="right">' . $row[buying_price] . '</td>
					<td align="center">' . $row[discount] . '&nbsp;%</td>
					<td align="center">' . $row[purchased_date] . '</td>';

		$result2 = mysqli_query($conn, "SELECT date FROM sales_has_items WHERE product_id LIKE '$product_id' AND cancel_status='0' ORDER BY id DESC LIMIT 1");
		while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
			echo '<td align="right">' . $row2[date] . '</td>';
		}
		echo '</tr>';

		$i++;
	}
		echo '			<tfoot>
							<th>No</th>
							<th>Product ID</th>
							<th>Product Name</th>
							<th>Product Catagory</th>
							<th>Stock</th>
							<th>Sold</th>
							<th>Selling Price</th>
							<th>Buying Price</th>
							<th>Discount</th>
							<th>Purchased Date</th>
							<th>Last Sales</th>
						</tfoot>
					</tbody>
				</table>
			</div>
		</div>';

	include 'conf/closedb.php';

}

function inventory_demand_report() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	clear_temp_demand();

	$result2 = mysqli_query($conn, "SELECT product_id FROM inventory WHERE cancel_status='0' ORDER BY id DESC LIMIT 500");
	while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
		$product_id = $row2[product_id];

		$result1 = mysqli_query($conn, "SELECT SUM(quantity) as sold FROM sales_has_items WHERE product_id='$product_id' AND cancel_status='0' ORDER BY id DESC LIMIT 500");
		while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
			$sold = $row1[sold];
			if ($sold == 0) {

			} else {
				temp_demand($sold, $product_id);
			}
		}
	}

	echo '<h3>Products on denmand</h3>
			<div class="row">      							
					<div class="box-body">
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<th>No</th>
								<th>Product ID</th>
								<th>Product Name</th>
								<th>Product Catagory</th>
								<th>Stock</th>
								<th>Sold</th>
								<th>Selling Price</th>
								<th>Buying Price</th>
								<th>Discount</th>
								<th>Purchased Date</th>
								<th>Last Sales</th>
							</thead>
						<tbody>';

	$i = 1;

	$result3 = mysqli_query($conn, "SELECT * FROM temp_demand ORDER BY total DESC");
	while ($row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
		$product_id = $row3[product_id];
		$result = mysqli_query($conn, "SELECT * FROM inventory WHERE product_id='$product_id' ORDER BY id DESC LIMIT 500");
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

			echo '
						<tr><td align="center">' . $i . '</td>
							<td>' . $row[product_id] . '</td>
									
							<td>' . $row[product_name] . '</td>
									
							<td>' . $row[catagory] . '</td>
									
							<td align="right">' . $row[quantity] . '</td>
							
							<td align="right" style="background-color: #0F6F2E; color: white;">' . $row3[total] . '</td>
							
							<td align="right">' . $row[selling_price] . '</td>
							
							<td align="right">' . $row[buying_price] . '</td>
							<td align="center">' . $row[discount] . '&nbsp;%</td>
							<td align="center">' . $row[purchased_date] . '</td>';

			$result4 = mysqli_query($conn, "SELECT date FROM sales_has_items WHERE product_id LIKE '$product_id' AND cancel_status='0' ORDER BY id DESC LIMIT 1");
			while ($row4 = mysqli_fetch_array($result4, MYSQLI_ASSOC)) {
				echo '<td align="right">' . $row4[date] . '</td>';
			}
			echo '</tr>';

			$i++;
		}
	}
	echo '				<tfoot>
							<th>No</th>
							<th>Product ID</th>
							<th>Product Name</th>
							<th>Product Catagory</th>
							<th>Stock</th>
							<th>Sold</th>
							<th>Selling Price</th>
							<th>Buying Price</th>
							<th>Discount</th>
							<th>Purchased Date</th>
							<th>Last Sales</th>
						</tfoot>
					</tbody>
				</table>
			</div>
		</div>';

	include 'conf/closedb.php';
}

function temp_demand($sold, $product_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO temp_demand (id, product_id, total)
	VALUES ('', '$product_id', '$sold')";
	mysqli_query($conn, $query) or die(mysqli_error($conn));

}

function clear_temp_demand() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "DELETE FROM temp_demand WHERE 1=1";

	mysqli_query($conn, $query);

}

function product_profit_report() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	clear_temp_profit();

	$result2 = mysqli_query($conn, "SELECT product_id FROM inventory WHERE cancel_status='0' ORDER BY id DESC LIMIT 500");
	while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
		$product_id = $row2[product_id];

		$result1 = mysqli_query($conn, "SELECT SUM(total) as sales_total FROM sales_has_items WHERE product_id='$product_id' AND cancel_status='0' AND saved='1' ORDER BY id DESC LIMIT 1");
		while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
			$sales_total = $row1[sales_total];

			$result5 = mysqli_query($conn, "SELECT SUM(quantity) as sold FROM sales_has_items WHERE product_id='$product_id' AND cancel_status='0' AND saved='1' ORDER BY id DESC LIMIT 1");
			while ($row5 = mysqli_fetch_array($result5, MYSQLI_ASSOC)) {
				$sold = $row5[sold];
				$info = get_inventory_info_by_product_id($product_id);
				$buying_price = $info[buying_price];
				$buy_total = $buying_price * $sold;
				$profit = $sales_total - $buy_total;
				if ($profit > 0) {
					temp_profit($sales_total, $product_id, $sold, $profit, $buy_total);
				} else {

				}
			}
		}
	}

	echo '<h3>Products with Profit</h3><div class="table-responsive">
              <table class="table">
		<thead valign="top">
		<th>No</th>
		<th>Product ID</th>
		<th>Product Name</th>
		<th>Sold</th>
		<th>Sales Total</th>
		<th>Buying Total</th>
		<th>Profit</th>
		<th>Last Sales</th>
		</thead>
		<tbody valign="top">';

	$i = 1;

	$result3 = mysqli_query($conn, "SELECT * FROM temp_profit ORDER BY profit DESC LIMIT 500");
	while ($row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
		$product_id = $row3[product_id];
		$result = mysqli_query($conn, "SELECT * FROM inventory WHERE product_id='$product_id' ORDER BY id DESC");
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

			echo '
							<tr><td align="center">' . $i . '</td>
								<td>' . $row[product_id] . '</td>
										
								<td>' . $row[product_name] . '</td>
								
								<td align="right">' . $row3[total_qty] . '</td>
								
								<td align="right">' . $row3[sales_total] . '</td>
								<td align="right">' . $row3[buy_total] . '</td>
								<td align="right" style="background-color: #0F6F2E; color: white;">' . $row3[profit] . '</td>';

			$result4 = mysqli_query($conn, "SELECT date FROM sales_has_items WHERE product_id LIKE '$product_id' AND cancel_status='0' ORDER BY id DESC LIMIT 1");
			while ($row4 = mysqli_fetch_array($result4, MYSQLI_ASSOC)) {
				echo '<td align="center">' . $row4[date] . '</td>';
			}
			echo '</tr>';

			$i++;
		}
	}
	echo '</tbody></table></div>';

	include 'conf/closedb.php';

}

function temp_profit($sales_total, $product_id, $sold, $profit, $buy_total) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO temp_profit (id, product_id, total_qty, sales_total, buy_total, profit)
	VALUES ('', '$product_id', '$sold', '$sales_total', '$buy_total', '$profit')";
	mysqli_query($conn, $query) or die(mysqli_error($conn));

}

function clear_temp_profit() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "DELETE FROM temp_profit WHERE 1=1";

	mysqli_query($conn, $query);

}

function product_loss_report() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	clear_temp_loss();

	$result2 = mysqli_query($conn, "SELECT product_id FROM inventory WHERE cancel_status='0' ORDER BY id DESC LIMIT 500");
	while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
		$product_id = $row2[product_id];

		$result1 = mysqli_query($conn, "SELECT SUM(total) as sales_total FROM sales_has_items WHERE product_id='$product_id' AND cancel_status='0' AND saved='1' ORDER BY id DESC LIMIT 1");
		while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
			$sales_total = $row1[sales_total];

			$result5 = mysqli_query($conn, "SELECT SUM(quantity) as sold FROM sales_has_items WHERE product_id='$product_id' AND cancel_status='0' AND saved='1' ORDER BY id DESC LIMIT 1");
			while ($row5 = mysqli_fetch_array($result5, MYSQLI_ASSOC)) {
				$sold = $row5[sold];
				$info = get_inventory_info_by_product_id($product_id);
				$buying_price = $info[buying_price];
				$buy_total = $buying_price * $sold;
				$loss = $buy_total - $sales_total;
				if ($loss > 0) {
					temp_loss($sales_total, $product_id, $sold, $loss, $buy_total);
				} else {

				}
			}
		}
	}

	echo '<h3>Products with loss</h3><div class="table-responsive">
              <table class="table">
		<thead valign="top">
		<th>No</th>
		<th>Product ID</th>
		<th>Product Name</th>
		<th>Sold</th>
		<th>Sales Total</th>
		<th>Buying Total</th>
		<th>Loss</th>
		<th>Last Sales</th>
		</thead>
		<tbody valign="top">';

	$i = 1;

	$result3 = mysqli_query($conn, "SELECT * FROM temp_loss ORDER BY loss DESC LIMIT 500");
	while ($row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
		$product_id = $row3[product_id];
		$result = mysqli_query($conn, "SELECT * FROM inventory WHERE product_id='$product_id' ORDER BY id DESC");
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

			echo '
							<tr><td align="center">' . $i . '</td>
								<td>' . $row[product_id] . '</td>
										
								<td>' . $row[product_name] . '</td>
								
								<td align="right">' . $row3[total_qty] . '</td>
								
								<td align="right">' . $row3[sales_total] . '</td>
								<td align="right">' . $row3[buy_total] . '</td>
								<td align="right" style="background-color: #920606; color: white;">' . $row3[loss] . '</td>';

			$result4 = mysqli_query($conn, "SELECT date FROM sales_has_items WHERE product_id LIKE '$product_id' AND cancel_status='0' ORDER BY id DESC LIMIT 1");
			while ($row4 = mysqli_fetch_array($result4, MYSQLI_ASSOC)) {
				echo '<td align="center">' . $row4[date] . '</td>';
			}
			echo '</tr>';

			$i++;
		}
	}
	echo '</tbody></table></div>';

	include 'conf/closedb.php';

}

function temp_loss($sales_total, $product_id, $sold, $loss, $buy_total) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO temp_loss (id, product_id, total_qty, sales_total, buy_total, loss)
	VALUES ('', '$product_id', '$sold', '$sales_total', '$buy_total', '$loss')";
	mysqli_query($conn, $query) or die(mysqli_error($conn));

}

function clear_temp_loss() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "DELETE FROM temp_loss WHERE 1=1";

	mysqli_query($conn, $query);

}

function recent_purchase_report() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<h3>Recently Purchased</h3><div class="table-responsive">
              <table class="table">
	<thead valign="top">
	<th>No</th>
	<th>Product ID</th>
	<th>Product Name</th>
	<th>Product Catagory</th>
	<th>Stock</th>
	<th>Sold</th>
	<th>Selling Price</th>
	<th>Buying Price</th>
	<th>Discount</th>
	<th>Purchased Date</th>
	<th>Last Sales</th>
	</thead>
	<tbody valign="top">';

	$i = 1;
	$result = mysqli_query($conn, "SELECT * FROM inventory WHERE cancel_status='0' AND quantity > '0' ORDER BY purchased_date DESC LIMIT 500");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		if ($row[quantity] == 0) {
			echo '
						<tr><td style="background-color:#920606; color:white;" align="center">' . $i . '</td>';
		} else {
			echo '
						<tr><td align="center">' . $i . '</td>';
		}
		echo '
					<td>' . $row[product_id] . '</td>
							
					<td>' . $row[product_name] . '</td>
							
					<td>' . $row[catagory] . '</td>
							
					<td align="right">' . $row[quantity] . '</td>
					
					';
		$product_id = $row[product_id];

		$result1 = mysqli_query($conn, "SELECT SUM(quantity) as sold FROM sales_has_items WHERE product_id LIKE '$product_id' AND cancel_status='0' ORDER BY id DESC LIMIT 500");
		while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
			echo '<td align="right">' . $row1[sold] . '</td>';
		}
		echo '
					<td align="right">' . $row[selling_price] . '</td>
					
					<td align="right">' . $row[buying_price] . '</td>
					<td align="center">' . $row[discount] . '&nbsp;%</td>
					<td align="center" style="background-color: #0F6F2E; color: white;">' . $row[purchased_date] . '</td>';

		$result2 = mysqli_query($conn, "SELECT date FROM sales_has_items WHERE product_id LIKE '$product_id' AND cancel_status='0' ORDER BY id DESC LIMIT 1");
		while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
			echo '<td align="right">' . $row2[date] . '</td>';
		}
		echo '</tr>';

		$i++;
	}
	echo '</tbody></table></div>';

	include 'conf/closedb.php';

}

function out_of_stock() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<h3>Out of Stock</h3><div class="table-responsive">
              <table class="table">
	<thead valign="top">
	<th>No</th>
	<th>Product ID</th>
	<th>Product Name</th>
	<th>Product Catagory</th>
	<th>Stock</th>
	<th>Sold</th>
	<th>Selling Price</th>
	<th>Buying Price</th>
	<th>Discount</th>
	<th>Purchased Date</th>
	<th>Last Sales</th>
	</thead>
	<tbody valign="top">';

	$i = 1;
	$result = mysqli_query($conn, "SELECT * FROM inventory WHERE cancel_status='0' AND quantity='0' ORDER BY id DESC LIMIT 500");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

		echo '
					<tr><td align="center">' . $i . '</td>
					<td>' . $row[product_id] . '</td>
							
					<td>' . $row[product_name] . '</td>
							
					<td>' . $row[catagory] . '</td>
							
					<td align="right"  style="background-color:#920606; color:white;">' . $row[quantity] . '</td>
					
					';
		$product_id = $row[product_id];

		$result1 = mysqli_query($conn, "SELECT SUM(quantity) as sold FROM sales_has_items WHERE product_id LIKE '$product_id' AND cancel_status='0' ORDER BY id DESC LIMIT 500");
		while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
			echo '<td align="right">' . $row1[sold] . '</td>';
		}
		echo '
					<td align="right">' . $row[selling_price] . '</td>
					
					<td align="right">' . $row[buying_price] . '</td>
					<td align="center">' . $row[discount] . '&nbsp;%</td>
					<td align="center">' . $row[purchased_date] . '</td>';

		$result2 = mysqli_query($conn, "SELECT date FROM sales_has_items WHERE product_id LIKE '$product_id' AND cancel_status='0' ORDER BY id DESC LIMIT 1");
		while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
			echo '<td align="right">' . $row2[date] . '</td>';
		}
		echo '</tr>';

		$i++;
	}
	echo '</tbody></table></div>';

	include 'conf/closedb.php';
}

function without_sales() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<h3>Products without sales</h3><div class="table-responsive">
              <table class="table">
	<thead valign="top">
	<th>No</th>
	<th>Product ID</th>
	<th>Product Name</th>
	<th>Product Catagory</th>
	<th>Stock</th>
	<th>Selling Price</th>
	<th>Buying Price</th>
	<th>Discount</th>
	<th>Purchased Date</th>
	</thead>
	<tbody valign="top">';

	$result = mysqli_query($conn, "SELECT * FROM inventory WHERE cancel_status='0' ORDER BY id DESC LIMIT 500");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

		$product_id = $row[product_id];
		$i = 1;
		$result1 = mysqli_query($conn, "SELECT SUM(quantity) as sold FROM sales_has_items WHERE product_id LIKE '$product_id' AND cancel_status='0' ORDER BY id DESC LIMIT 500");
		while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
			if ($row1[sold]) {

			} else {
				echo '
							<tr><td align="center">' . $i . '</td>
							<td>' . $row[product_id] . '</td>
									
							<td>' . $row[product_name] . '</td>
									
							<td>' . $row[catagory] . '</td>
									
							<td align="right"  style="background-color:#920606; color:white;">' . $row[quantity] . '</td>
							<td align="right">' . $row[selling_price] . '</td>
							
							<td align="right">' . $row[buying_price] . '</td>
							<td align="center">' . $row[discount] . '&nbsp;%</td>
							<td align="center">' . $row[purchased_date] . '</td>';

				echo '</tr>
							';
			}
			$i++;
		}

	}
	echo '</tbody></table></div>';

	include 'conf/closedb.php';

}


function list_inventory() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo'<div class="box-body"> 
                        <table id="example1" style="width: 100%;" class=" table-responsive table-bordered table-striped dt-responsive" cellspacing="0">
                              <thead>
                                  <tr style="height: 30px;">
                                    <th>Edit</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Stock</th>
                                    <th>S.Price</th>
                                    <th>B.Price</th>
                                    <th>P.Date</th>
                                    
                                    <th></th>                  
                                  </tr>
                              </thead>
                              <tbody>';
	$result = mysqli_query($conn, "SELECT * FROM inventory WHERE cancel_status='0' ORDER BY id DESC LIMIT 100");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo '
				<tr>
					<td><a href="inventory.php?job=edit&id=' . $row[id] . '"  ><i class="fa fa-pencil-square-o"></i></a></td>
					<td>' . $row[product_id] . '</td>					
					<td>' . $row[product_name] . '</td>
							
					<td align="right">' . $row[quantity] . '</td>
				';
		if ($row[selling_price] == 0) {
			echo '
						<td style="background-color:#920606; color:white;" align="right">' . $row[selling_price] . '</td>';
		} else {
			echo '
						<td align="right">' . $row[selling_price] . '</td>';
		}
		echo '
					<td align="right">' . $row[buying_price] . '</td>
				
					<td align="center">' . $row[purchased_date] . '</td>
				
					
					<td><a href="html/BCGcode39.php?barcode=' . $row[barcode] . '&product_id=' . $row[product_id] . '&price=' . $row[selling_price] . '&name=' . $row[product_name] . '&type=' . $row[type] . '" target="blank" class="btn btn-sm btn-success" style="height: 30px; padding: 2px;">Print</a></td>
				</tr>';
	}
	echo '</tbody></table></div></div>';

	include 'conf/closedb.php';
}


function update_temp_catagory(){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
		$i = 1;
		$result = mysqli_query($conn, "SELECT * FROM catagories WHERE cancel_status='0' ORDER BY id DESC LIMIT 500");
		while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
			if ($row1[sold]) {

			} else {
				echo '
							<tr><td align="center">' . $i . '</td>
							<td>' . $row[product_id] . '</td>
									
							<td>' . $row[product_name] . '</td>
									
							<td>' . $row[catagory] . '</td>
									
							<td align="right"  style="background-color:#920606; color:white;">' . $row[quantity] . '</td>
							<td align="right">' . $row[selling_price] . '</td>
							
							<td align="right">' . $row[buying_price] . '</td>
							<td align="center">' . $row[discount] . '&nbsp;%</td>
							<td align="center">' . $row[purchased_date] . '</td>';

				echo '</tr>
							';
			}
			$i++;
		}

	
	
}

function _catagory_listing(){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query($conn, "SELECT * FROM catagories WHERE parent_catagory='' ORDER BY id DESC LIMIT 500");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				echo $row[catagory] . '<br />';
				
				$result2 = mysqli_query($conn, "SELECT * FROM catagories WHERE parent_catagory='$row[catagory]' ORDER BY id DESC LIMIT 500");
				while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
					echo '-'.$row2[catagory] . '<br />';
				}
		}

	
		
	include 'conf/closedb.php';
}

//tree test start
function hasChild($parent_cat)
{
	$sql = "SELECT COUNT(*) as count FROM catagories WHERE parent_catagory = '" . $parent_cat . "'";
	$qry = mysqli_query($sql);
	$rs = mysqli_fetch_array($qry);
	return $rs['count'];
}

function CategoryList()
{
	
	
	$list = "";

	$sql = "SELECT * FROM catagories WHERE (parent_catagory = '' OR parent_catagory IS NULL)";
	$qry = mysqli_query($sql);
	$parent = mysqli_fetch_array($qry);
	$mainlist = "<ul class='parent'>";
	do{
		$mainlist .= CategoryTree($list,$parent,$append = 0);
	}while($parent = mysqli_fetch_array($qry));
	$list .= "</ul>";
	echo  $mainlist;
}



function CategoryTree($list,$parent,$append)
{
	$list = '<li><a href="inv_full_report.php?job=list_inventory_by_cat&cat='.$parent[catagory].'" >'.$parent['catagory'].'</a></li>';

	if (hasChild($parent['catagory'])) // check if the id has a child
	{
		$append++;
		$list .= "<ul class='child child".$append."'>";
		$sql = "SELECT * FROM catagories WHERE parent_catagory = '" . $parent['catagory'] . "'";
		$qry = mysqli_query($sql);
		$child = mysqli_fetch_array($qry);
		do{
			$list .= CategoryTree($list,$child,$append);
		}while($child = mysqli_fetch_array($qry));
		$list .= "</ul>";
	}
	return $list;
}



function hasChild_1($parent_cat)
{
	$sql = "SELECT COUNT(*) as count FROM catagories WHERE parent_catagory = '" . $parent_cat . "'";
	$qry = mysqli_query($sql);
	$rs = mysqli_fetch_array($qry);
	return $rs['count'];
}

function list_inventory_by_cat($category)
{
	$list = "";

	$sql = "SELECT * FROM catagories WHERE catagory = '$category'";
	$qry = mysqli_query($sql);
	$parent = mysqli_fetch_array($qry);
	$mainlist = "<ul class='parent'>";
	do{
		$mainlist .= CategoryTree_1($list,$parent,$append = 0);
	}while($parent = mysqli_fetch_array($qry));
	$list .= "</ul>";
	echo  $mainlist;
}



function CategoryTree_1($list,$parent,$append)
{
	
	$list_product=list_products_by_cat($parent[catagory]);
	//$list = '<li><a href="inv_full_report.php?job=list_inventory_by_cat&cat='.$parent[catagory].'" >'.$parent['catagory'].'</a><br />'.$list_product.'</li>';
	$list = $list_product;
	if (hasChild($parent['catagory'])) // check if the id has a child
	{
		$append++;
		//$list .= "<ul class='child child".$append."'>";
		$sql = "SELECT * FROM catagories WHERE parent_catagory = '" . $parent['catagory'] . "'";
		$qry = mysqli_query($sql);
		$child = mysqli_fetch_array($qry);
		do{
			$list .= CategoryTree_1($list,$child,$append);
		}while($child = mysqli_fetch_array($qry));
	//	$list .= "</ul>";
	}
	return $list;
}

function list_products_by_cat($category) {
	
include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<h3>'.$category.'</h3><div class="table-responsive">
              <table class="table">
	<thead valign="top">
	<th>No</th>
	<th>Product ID</th>
	<th>Product Name</th>
	<th>Product Catagory</th>
	<th>Stock</th>
	<th>Selling Price</th>
	<th>Buying Price</th>
	<th>Discount</th>
	<th>Purchased Date</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM inventory WHERE catagory='$category' AND cancel_status='0' ORDER BY id ASC LIMIT 500");
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {


				echo '
							<tr><td align="center">' . $i . '</td>
							<td>' . $row[product_id] . '</td>
									
							<td>' . $row[product_name] . '</td>
									
							<td>' . $row[catagory] . '</td>
									
							<td align="right"  style="background-color:#920606; color:white;">' . $row[quantity] . '</td>
							<td align="right">' . $row[selling_price] . '</td>
							
							<td align="right">' . $row[buying_price] . '</td>
							<td align="center">' . $row[discount] . '&nbsp;%</td>
							<td align="center">' . $row[purchased_date] . '</td>';

				echo '</tr>
							';
			}

	echo '</tbody></table></div>';

	/*
	$output=NULL;
	
	$result=mysqli_query($conn, "SELECT * FROM inventory WHERE catagory='$category' AND cancel_status='0' ORDER BY id ASC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{

		$output .= $row['product_name']."<br />";
	}
	
	return $output;
	
	*/
}

//tree test end

function list_item_for_selling_price(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM inventory WHERE selling_price<'1' AND cancel_status='0' ORDER BY id ASC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo'<tr>
		<form name="update_item" action="selling_price.php?job=add_selling_price&product_id='.$row[product_id].'" method="post">'."
		<td>$row[product_name]</td>
		<td>$row[product_id]</td>
		<td align='right'><input type='text' name='selling_price' value='$row[selling_price]' size='10' style='color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;'/></td>
				<td align='right'><input type='submit' name='update' value='Update' size='9' class='more' style='width: 70px; border: 0; padding: 1.5px;'/></td>
		</form></tr>";

	}



	include 'conf/closedb.php';


}

function update_selling_price($product_id, $selling_price, $user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE inventory SET
	selling_price='$selling_price',
	updated_by='$user_name'
	WHERE product_id='$product_id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function list_label($id){
	$info=get_product_info($id);
	
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result=mysqli_query($conn, "SELECT * FROM item_has_label WHERE product_id='$info[product_id]' ORDER BY label ASC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo'<option value="'.$row[label].'" selected>'.$row[label].'</option>';
	}
	
	$result1=mysqli_query($conn, "SELECT * FROM label WHERE label.label NOT IN (SELECT label FROM item_has_label WHERE product_id='$info[product_id]') ORDER BY label ASC");
	while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC))
	{
		echo'<option value="'.$row1[label].'">'.$row1[label].'</option>';
	}
}


function inv_stock() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<h3>Stock</h3>
	<div class="table-responsive">
              <table class="table">
	<thead valign="top">
	<th>No</th>
	<th>Product ID</th>
	<th>Product Name</th>
	<th>Stock</th>
	<th>Selling Price</th>
	<th>Discount</th>
	<th>Purchased Date</th>

	</thead>
	<tbody valign="top">';

	$i = 1;
	$result1 = mysqli_query($conn, "SELECT * FROM inventory_has_multiple_stock WHERE  branch='$_SESSION[branch]' ORDER BY id DESC LIMIT 500");
	while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
	
				$result = mysqli_query($conn, "SELECT * FROM inventory WHERE cancel_status='0' AND product_id='$row1[product_id]' ORDER BY id DESC LIMIT 500");
				while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			
					echo '
								<tr><td align="center">' . $i . '</td>
								<td>' . $row[product_id] . '</td>
										
								<td>' . $row[product_name] . '</td>
										
								<td align="right">' . $row1[stock] . '</td>
										
								<td align="right">' . $row[selling_price] . '</td>
								
								<td align="center">' . $row[discount] . '&nbsp;%</td>
								
								<td align="center">' . $row[purchased_date] . '</td>
								<tr>';
			
					$i++;
				}
	}
	echo '</tbody></table></div>';

	include 'conf/closedb.php';
}



function head_office_inv_stock() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<h3>Stock</h3>
	<div class="table-responsive">
              <table class="table">
	<thead valign="top">
	<th>No</th>
	<th>Product ID</th>
	<th>Product Name</th>
	<th>Stock</th>
	<th>Selling Price</th>
	<th>Discount</th>
	<th>Purchased Date</th>

	</thead>
	<tbody valign="top">';

	$i = 1;
	$result1 = mysqli_query($conn, "SELECT DISTINCT product_id FROM inventory_has_multiple_stock ORDER BY id DESC LIMIT 500");
	while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
	
				
				$result = mysqli_query($conn, "SELECT * FROM inventory WHERE cancel_status='0' AND product_id='$row1[product_id]' ORDER BY id DESC LIMIT 500");
				while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$stock= count_stock($row['product_id']);
				
					echo '
								<tr><td align="center">' . $i . '</td>
								<td>' . $row[product_id] . '</td>
										
								<td>' . $row[product_name] . '</td>
										
								<td align="right">'.$stock.'</td>
										
								<td align="right">' . $row[selling_price] . '</td>
								
								<td align="center">' . $row[discount] . '&nbsp;%</td>
								
								<td align="center">' . $row[purchased_date] . '</td>
								<tr>';
			
					$i++;
				}
	}
	echo '</tbody></table></div>';

	include 'conf/closedb.php';
}


function count_stock($product_id){
	include 'conf/config.php';
	include 'conf/opendb.php';
		
		$result=mysqli_query($conn, "SELECT SUM(stock) AS cnt FROM inventory_has_multiple_stock WHERE product_id='$product_id' ");
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{	
				$count=$row[cnt];
				return $count;						
		}
			

}


function list_inventory_label($product_id){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result=mysqli_query($conn, "SELECT * FROM label WHERE product_id='$product_id' )" );
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$label = $row ['label'];

		$i ++;

	}
	
		return $label;
}