<?php
function get_total_stock_return($product_id){
	include 'conf/config.php';
	include 'conf/opendb.php';


	$result=mysqli_query($conn, "SELECT sum(quantity) as total FROM inventory WHERE product_id='$product_id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row[total];
	}

	return $total;

	include 'conf/closedb.php';
}

function get_total_return($return_no){
	include 'conf/config.php';
	include 'conf/opendb.php';


	$result=mysqli_query($conn, "SELECT sum(total) as total FROM return_has_items WHERE return_no='$return_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row[total];
	}

	return $total;

	include 'conf/closedb.php';
}

function add_return_item($selected_item, $product_id, $stock, $selling_price, $discount, $return_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d");
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO return_has_items (id, product_id, product_name, stock, selling_price, date, discount, return_no, quantity, user_name, total)
	VALUES ('', '$product_id', '$selected_item', '$stock', '$selling_price', '$date', '$discount', '$return_no', '1', '$_SESSION[user_name]', '$selling_price')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function check_non_saved_return_order($user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT count(id) FROM return_has_items WHERE user_name='$user_name' AND saved='0'");
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

function non_save_return_info($user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MIN(return_no) FROM return_has_items WHERE user_name='$user_name' AND saved='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MIN(return_no)'];
	}

	include 'conf/closedb.php';
}

function get_return_no(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MAX(return_no) FROM return_has_items");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(return_no)']+1;
	}

	include 'conf/closedb.php';
}

function check_added_items_return($product_id, $return_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT count(id) FROM return_has_items WHERE product_id='$product_id' AND return_no='$return_no' AND cancel_status='0'");
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

function update_return_item($product_id, $quantity, $item_total, $selling_price, $discount, $return_no, $stock){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE return_has_items SET
	quantity='$quantity',
	selling_price='$selling_price',
	discount='$discount',
	total='$item_total',
	saved='0',
	stock='$stock'
	WHERE product_id='$product_id' AND cancel_status='0' AND return_no='$return_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function update_return_item_for_repeative_adding($product_id, $quantity, $item_total){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE return_has_items SET
	quantity='$quantity',
	total='$item_total',
	saved='0'
	WHERE product_id='$product_id' AND cancel_status='0'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_quantity_return($product_id, $return_no){
	include 'conf/config.php';
	include 'conf/opendb.php';


	$result=mysqli_query($conn, "SELECT sum(quantity) as total FROM return_has_items WHERE product_id='$product_id' AND return_no='$return_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row[total];
	}

	return $total;

	include 'conf/closedb.php';
}
function list_item_by_return($return_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM return_has_items WHERE return_no='$return_no' AND cancel_status='0' ORDER BY id ASC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo'<tr>
		<form name="update_item" action="return.php?job=update_item&product_id='.$row[product_id].'" method="post"><td align="center" ><a href="return.php?job=delete_item&id='.$row[id].'" ><img src="images/close.png" alt="Delete" /></a></td>'."
		<td>$row[product_name]</td>
		<td>$row[product_id]</td>
		<td align='right'>$row[stock]</td>
		<td align='right'><input type='text' name='selling_price' value='$row[selling_price]' size='10' style='color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;'/></td>
		<td align='right'><input type='text' name='quantity' value='$row[quantity]' size='6' style='color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;'/></td>
		<td align='right'><input type='text' name='discount' value='$row[discount]' size='9' style='color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;'/></td>
		<td align='right'>$row[total]</td>
		<td align='right'><input type='submit' name='update' value='Update' size='9' class='more' style='width: 70px; border: 0; padding: 1.5px;'/></td>
		</form></tr>";

	}



	include 'conf/closedb.php';


}

function get_product_info_from_return_has_items($product_id, $return_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM return_has_items WHERE product_id='$product_id' AND return_no='$return_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_product_info_from_return_has_items_by_id($id){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM return_has_items WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function cancel_item_return($id){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE return_has_items SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]',
	saved='0'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function update_saved_return($return_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE return_has_items SET
	saved='1'
	WHERE return_no='$return_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}


function save_return($return_no, $date, $customer_name, $prepared_by, $remarks, $total){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d", strtotime($date));
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO returns (id, return_no, customer_name, prepared_by, remarks, date, total, due)
	VALUES ('', '$return_no', '$customer_name', '$prepared_by', '$remarks', '$date', '$total', '$total')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}


function list_return_search($return_no_search, $customer_search){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if($return_no_search && $customer_search){
		$and="AND ";
	}
	else{
		$and="";
	}
	
	if($return_no_search){
		$return_no_check="return_no LIKE '%$return_no_search'";
	}
	else{
		$return_no_check="";
	}

	if($customer_search){
		$customer_check="customer_name='$customer_search'";
	}
	else{
		$customer_check="";
	}
	
	if($return_no_search || $customer_search){
	
	echo '<table class="inventory_table" style="width: 900px; border-bottom: 2px solid silver; margin-bottom: 30px; margin-top: 0x;">
	<thead valign="top">
	<th>Edit</th>
	<th>Print</th>
	<th>Return No</th>
	<th>Return Date</th>
	<th>Customer Name</th>
	<th>Return Total</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	<th>Delete</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM returns WHERE $customer_check $and $return_no_check AND cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="return.php?job=edit&id='.$row[id].'"  ><img src="images/edit.png" alt="Edit" /></a></td>

			<td><a href="return.php?job=print_preview&id='.$row[id].'"  ><img src="images/print.png" alt="Print" width="24" height="24" /></a></td>
			
			<td>'.$row[return_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[customer_name].'</td>
			
			<td align="right">'.$row[total].'</td>
		
			<td align="center">'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'return.php?job=delete&id='.$row[id].'\',\'No\',\'return.php?job=search\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';
	}
	
	include 'conf/closedb.php';
}

function get_return_info($id){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM returns WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_return_info_by_return_no($return_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM returns WHERE return_no='$return_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function update_return($id, $return_no, $date, $customer_name, $prepared_by, $remarks, $total, $updated_by){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d", strtotime($date));

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE returns SET
	return_no='$return_no',
	date='$date',
	customer_name='$customer_name',
	prepared_by='$prepared_by',
	remarks='$remarks',
	total='$total',
	due='$total',
	updated_by='$updated_by' 
	WHERE id='$id'";

	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function  calncel_items_for_return_no($return_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE return_has_items SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]',
	saved='1'
	WHERE return_no='$return_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function cancel_return($id){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE returns SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_return_item_id($return_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MAX(id) FROM return_has_items WHERE  cancel_status='0' ");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(id)'];
	}

	include 'conf/closedb.php';
}